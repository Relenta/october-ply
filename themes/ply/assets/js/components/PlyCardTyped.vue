<template>
    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--12-col" v-if="!answered">
            <div class="ply-simple-card mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title">
                    <h2 class="mdl-card__title-text">Side 1</h2>
                </div>
                <div class="mdl-card__supporting-text">
                    <h2>{{ card.sides[0].content }}</h2>
                </div>
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <button 
                    @click="playSide(0)"
                    class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                    Play
                </button>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text" v-model="answer">
                    <label class="mdl-textfield__label" for="sample3">Answer...</label>
                </div>
                <button
                    @click="submitAnswer" 
                    class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                    Submit
                </button>
            </div>
        </div>
        <div class="mdl-cell mdl-cell--12-col" v-if="answered">
            <div class="ply-simple-card mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title">
                    <h2 class="mdl-card__title-text">Side 2</h2>
                </div>
                <div class="mdl-card__supporting-text">
                    <h2>{{ card.sides[1].content }}</h2>
                </div>
            </div>
        </div>
    </div>

</template>

<style>
    .ply-simple-card {
        width: 100%;
    }
</style>

<script>
    import { playAudio } from '../helpers.js';
    import * as stringSimilarity from 'string-similarity';

    export default {
        props: ['card', 'sideTimeout'],
        data() {
            return {
                answered: false,
                answer: ''
            }
        },
        created() {
            this.playSide(0);
        },
        watch: {
            card() {
                this.answered = false;
                this.playSide(0);
            }
        },
        methods: {
            submitAnswer() {
                if( stringSimilarity
                        .compareTwoStrings(this.answer, this.card.sides[1].content) > 0.85) {
                    alert('Correct!!!');
                } else {
                    alert('Incorrect!!!');
                }
                this.answer = '';
                this.showNextSide();
            },
            showNextSide() {
                this.answered = true;
                setTimeout(() => {
                    this.playSide(1).then(this.endCard);
                }, this.sideTimeout);
            },
            endCard() {
                this.$emit('endCard');
            },
            playSide(index) {
                return playAudio(this.card.sides[index].media.path, this.sideTimeout);
            }
        }
    }
</script>