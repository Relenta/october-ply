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
            <div class="mdl-card__actions mdl-card--border">
                <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                    Yes
                </a>
                <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                    No
                </a>
                <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                    Maybe
                </a>
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
    export default {
        props: ['card', 'sideTimeout'],
        data() {
            return {
                currentSide: 0
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