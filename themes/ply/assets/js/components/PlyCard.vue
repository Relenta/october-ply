<template>
    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--6-col">
            <div class="ply-simple-card mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title">
                    <h2 class="mdl-card__title-text">Side 1</h2>
                </div>
                <div class="mdl-card__supporting-text">
                    <h2>{{ card.sides[0].content }}</h2>
                </div>
                <div class="mdl-card__actions mdl-card--border">
                    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                        Replay
                    </a>
                </div>
            </div>
        </div>
        <div class="mdl-cell mdl-cell--6-col">
            <div class="ply-simple-card mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title">
                    <h2 class="mdl-card__title-text">Side 2</h2>
                </div>
                <div class="mdl-card__supporting-text">
                    <h2>{{ card.sides[1].content }}</h2>
                </div>
                <div class="mdl-card__actions mdl-card--border">
                    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                        Replay
                    </a>
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
    export default {
        props: ['card'],
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
                if(!this.side_1.media) return;
                let media_1 = new Audio(this.side_1.media.path);
                media_1.onended = this.playSecondMedia;
                media_1.play();
            },
            playSecondMedia() {
                if(!this.side_2.media) return;
                let media_2 = new Audio(this.side_2.media.path);
                media_2.play();
            }
        },
        computed: {
            side_1() {
                return this.card.sides[0] || null;
            },
            side_2() {
                return this.card.sides[1] || null;
            }
        }
    }
</script>