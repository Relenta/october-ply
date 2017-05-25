<template>
    <div>
        <div id="progressbar" class="mdl-progress mdl-js-progress"></div>

        <ply-card-listen
            v-if="currentCard"
            :card="currentCard"
            :sideTimeout="sideTimeout"
            @endCard="nextCard">
        </ply-card-listen>

        <center>
            <button
                    v-if="playing"
                    @click="playing = ! playing"
                    class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
            Pause
            </button>
            <button
                    v-if="!playing"
                    @click="resume"
                    class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
            Resume
            </button>
        </center>
    </div>
</template>

<style>
    #progressbar {
        width: 100%;
        height: 6px;
    }
</style>

<script>
    import PlyLearnBase from './PlyLearnBase.js';
    import PlyCardListen from './PlyCardListen';
    export default {
        props: ['cardTimeout', 'sideTimeout'],
        extends: PlyLearnBase,
        data() {
            return {
                playing: true
            }
        },
        computed: {
            currentCard() {
                return this.cards[this.current] || null;
            }
        },
        methods: {
            nextCard() {
                setTimeout(() => {
                    if(!this.playing) return;

                    this.progressBar.setProgress(Math.round(100 * (this.current + 1) / this.cards.length));

                    if(this.current < this.cards.length - 1) {
                        this.current += 1;
                    } else {
                        setTimeout(this.endLessonSuccess, 500);
                    }
                }, this.cardTimeout);
            },
            resume() {
                this.playing = true;
                this.nextCard();
            }
        },
        components: {
            PlyCardListen
        }
    }
</script>
