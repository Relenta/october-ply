<template>
    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--12-col">
            <div class="ply-simple-card mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title">
                    <h2 class="mdl-card__title-text">Side {{ currentSide + 1 }}</h2>
                </div>
                <div class="mdl-card__supporting-text">
                    <h2>{{ card.sides[currentSide].content }}</h2>
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
    import { playAudio, forEachPromise } from '../helpers.js'
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
                // console.log(index);
                this.currentSide = index;
                return playAudio(side.media.path, this.sideTimeout);
            },
            endCard() {
                this.$emit('endCard');
            }
        }
    }
</script>