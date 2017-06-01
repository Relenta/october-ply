<template>
    <div>
        <div id="progressbar" class="mdl-progress mdl-js-progress"></div>

        <ply-card-flash
            v-if="currentCard"
            :card="currentCard"
            @cardAnswered="nextCard"
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
                return this.cards[0] || null;
            }
        },
        methods: {
            nextCard(answer) {
                setTimeout(() => {

                    const currentCard = this.cards.shift();

                    window.eventBus.$emit('cardChanged');

                    // Check type value
                    if (answer === 'no') {
                        this.cards.push(currentCard);
                        return;
                    }

                    // Update progress
                    this.progressBar.setProgress(Math.round(100 * this.currentIndex / this.count));

                    // Check course progress
                    if(this.cards.length == 0) {
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
