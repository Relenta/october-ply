<template>
    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--12-col">
            <div class="ply-simple-card mdl-card mdl-shadow--2dp">
                <div class="mdl-card__supporting-text">
                    <h2>{{ card.sides[0].content }}</h2>
                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored"
                            v-if="card.sides[0].media"
                            @click="playSide(0)">
                        Play
                    </button>
                </div>
                <div v-if="answered">
                    <hr>
                    <div class="mdl-card__supporting-text" :class="answerStatus ? 'success' : 'error'">
                        <h2>{{ answerStatus }}: {{ card.sides[1].content }}</h2>
                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored"
                                v-if="card.sides[1].media"
                                @click="playSide(1)">
                            Play
                        </button>
                    </div>
                </div>
            </div>
            <div class="mdl-card__actions mdl-card--border" v-if="!answered">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text" v-model="answer">
                    <label class="mdl-textfield__label">Answer...</label>
                </div>
                <button
                    @click="submitAnswer"
                    class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                    Submit
                </button>
            </div>
        </div>
    </div>

</template>

<style>
    .ply-simple-card {
        width: 100%;
    }

    .error {
        background-color: darkred;
    }

    .success {
        background-color: green;
    }
</style>

<script>
    import {playAudio} from '../helpers.js';
    import * as stringSimilarity from 'string-similarity';

    export default {
        props: ['card', 'sideTimeout'],
        data() {
            return {
                answered: false,
                answer: '',
                answerStatus: ''
            }
        },
        created() {
            this.showSide(0);
        },
        watch: {
            card() {
                this.answered = false;
                this.answerStatus = '';
                this.showSide(0);
            }
        },
        methods: {
            submitAnswer() {
                let similarity = stringSimilarity.compareTwoStrings(this.answer, this.card.sides[1].content);

                this.answerStatus = similarity > 0.85;
                this.answer = '';
                this.answered = true;

                setTimeout(() => {
                    this.showSide(1).then(this.endCard);
                }, this.sideTimeout);
            },
            endCard() {
                this.$emit('cardAnswered', this.answerStatus);
            },
            showSide(index) {
                if (this.card.sides[index].hasOwnProperty['media']) {
                    this.playSide(index);
                }
                return new Promise((resolve) => {
                    setTimeout(resolve, this.sideTimeout);
                });
            },
            playSide(index) {
                return playAudio(this.card.sides[index].media.path, this.sideTimeout);
            }
        }
    }
</script>
