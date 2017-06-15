<template>
    <div class="mdl-cell--8-col learn-cards-container">
        <div class="learn-card card-side-0 mdl-card mdl-shadow--2dp" :class="{'answer-correct': currentSide == 0}">
            <div class="card-content mdl-card__supporting-text">
                {{ card.sides[0].content }}
            </div>
        </div>
        <!-- answer-correct answer-wrong -->
        <div class="learn-card card-side-1 mdl-card mdl-shadow--2dp" :class="{'answer-correct': currentSide == 1}">
            <div class="card-content mdl-card__supporting-text">
                {{ card.sides[1].content }}
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
    import {playAudio, forEachPromise} from '../helpers.js'
    export default {
        props: ['card', 'sideTimeout'],
        data() {
            return {
                currentSide: 0
            }
        },
        watch: {
            card() {
                this.playCardMedia();
            }
        },
        mounted() {
            this.playCardMedia();
        },
        methods: {
            playCardMedia() {
                forEachPromise(this.card.sides, this.learnSide).then(this.endCard);
            },
            learnSide(side, index) {
                this.currentSide = index;
                if (side.media) {
                    return playAudio(side.media.path, this.sideTimeout);
                } else {
                    return new Promise((resolve) => {
                        setTimeout(resolve, this.sideTimeout + 1);
                    });
                }
            },
            endCard() {
                this.$emit('endCard');
            }
        }
    }
</script>
