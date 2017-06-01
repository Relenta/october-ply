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
            </div>
            <div v-if="currentSide === 1">
                <div class="ply-simple-card mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__supporting-text">
                        <h2>{{ card.sides[1].content }}</h2>
                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored"
                                v-if="card.sides[1].media"
                                @click="playSide(1)">
                            Play
                        </button>
                    </div>
                </div>
            </div>
            <div v-if="currentSide === 1" class="mdl-card__actions mdl-card--border">
                <button
                    @click="answer('yes')"
                    class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                    Yes
                </button>
                <button
                    @click="answer('no')"
                    class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                    No
                </button>
                <button
                    @click="answer('maybe')"
                    class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                    Maybe
                </button>
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
