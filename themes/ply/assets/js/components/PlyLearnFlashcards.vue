<template>
    <div>
        <div id="progressbar" class="mdl-progress mdl-js-progress"></div>

        <ply-card-flash
            v-if="currentCard"
            :card="currentCard"
            @endCard="nextCard"
            :sideTimeout="sideTimeout">
        </ply-card-flash>
    </div>
</template>

<script>
    import PlyLearnBase from './PlyLearnBase.js';
    import PlyCardFlash from './PlyCardFlash';
    export default {
        props: ['cardTimeout', 'sideTimeout'],
        extends: PlyLearnBase,
        computed: {
            currentCard() {
                return this.cards[this.current] || null;
            }
        },
        methods: {
            nextCard() {
                setTimeout(() => {
                    this.progressBar.setProgress(Math.round(100 * (this.current + 1) / this.cards.length));

                    if(this.current < this.cards.length - 1) {
                        this.current += 1;
                    } else {
                        this.endLessonSuccess();
                    }
                }, this.cardTimeout);
            },
        },
        components: {
            PlyCardFlash
        }
    }
</script>

<style>
    #progressbar {
        width: 100%;
        height: 6px;
    }
</style>
