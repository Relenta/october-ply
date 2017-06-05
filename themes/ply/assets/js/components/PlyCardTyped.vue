<template>
    <div class="mdl-cell--8-col learn-cards-container">
        <div class="learn-card card-side-0 mdl-card mdl-shadow--2dp">
            <div class="card-content mdl-card__supporting-text">
                {{ card.sides[0].content }}
            </div>
            <div class="card-actions mdl-card__actions" v-if="card.sides[0].media">
                <button class="card-play-media mdl-button mdl-js-button mdl-button--icon mdl-button--colored" @click="playSide(0)">
                  <i class="material-icons">volume_up</i>
                </button>
            </div>
        </div>
        <div class="learn-card card-input mdl-card mdl-shadow--2dp" v-if="!answered">
            <div class="card-content mdl-card__supporting-text">
                <mdl-textfield floating-label="Answer:" v-model="answer"></mdl-textfield>
                <div class="submit-container">
                    <button
                        @click="submitAnswer"
                        class="mdl-button mdl-button--raised mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                        Submit
                    </button>
                </div>
            </div>
        </div>
        <!-- answer-correct answer-wrong -->
        <div class="learn-card card-side-1 mdl-card mdl-shadow--2dp" :class="answerStatus ? 'answer-correct' : 'answer-wrong'" v-if="answered">
            <div class="card-answer-status mdl-card__supporting-text">
                <i class="material-icons correct">check_circle</i>
                <i class="material-icons wrong">cancel</i>
            </div>
            <div class="card-content mdl-card__supporting-text">
                {{ card.sides[1].content }}
            </div>
            <div class="card-actions mdl-card__actions" v-if="card.sides[1].media">
                <button class="card-play-media mdl-button mdl-js-button mdl-button--icon mdl-button--colored" @click="playSide(1)">
                  <i class="material-icons">volume_up</i>
                </button>
            </div>
        </div>
    </div>
</template>

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
