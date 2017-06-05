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
        <!-- answer-correct answer-wrong -->
        <div class="learn-card card-side-1 mdl-card mdl-shadow--2dp" v-if="currentSide === 1">
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
        <div class="learn-card-actions mdl-grid" v-if="currentSide === 1">
            <div class="mdl-cell mdl-cell--4-col">
                <button @click="answer('no')" id="card-action-no" class="no mdl-button mdl-js-button mdl-button--raised">
                    Wrong
                </button>
            </div>
            <div class="mdl-cell mdl-cell--4-col">
                <button @click="answer('maybe')" id="card-action-maybe" class="maybe mdl-button mdl-js-button mdl-button--raised">
                    Almost
                </button>
            </div>
            <div class="mdl-cell mdl-cell--4-col">
                <button @click="answer('yes')" id="card-action-yes" class="yes mdl-button mdl-js-button mdl-button--raised">
                    Correct
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import {playAudio} from '../helpers.js';

    export default {
        props: ['card', 'sideTimeout'],
        data() {
            return {
                currentSide: 0
            }
        },
        created() {
            window.eventBus.$on('cardChanged', () => {
                this.currentSide = 0;
                this.learnCard();
            });
        },
        mounted() {
            this.learnCard();
        },
        methods: {
            answer(answerType) {
                axios.post('/api/v1/flash', {
                    card_id: this.card.id,
                    answer: answerType
                }).then(() => {
                    this.$emit('cardAnswered', answerType);
                });

            },
            endCard() {
                this.$emit('endCard');
            },
            playSide(index) {
                return playAudio(this.card.sides[index].media.path, this.sideTimeout);
            },
            showSide(index) {
                this.currentSide = index;
                if (this.card.sides[index].hasOwnProperty['media']) {
                    this.playSide(index);
                }
                return new Promise((resolve) => {
                    setTimeout(resolve, this.sideTimeout);
                });
            },
            learnCard() {
                this.showSide(0).then(() => {
                    setTimeout(() => {
                        this.showSide(1);
                    }, this.sideTimeout);
                });
            }
        }
    }
</script>
