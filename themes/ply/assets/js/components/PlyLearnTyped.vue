<template>
    <div>
        <div id="progressbar" class="mdl-progress mdl-js-progress"></div>

        <ply-card-typed
            v-if="currentCard"
            :card="currentCard"
            @cardAnswered="nextCard"
            :sideTimeout="sideTimeout">
        </ply-card-typed>
    </div>
</template>

<script>
    import PlyLearnBase from './PlyLearnBase.js';
    import PlyCardTyped from './PlyCardTyped';

    export default {
        props: ['cardTimeout', 'sideTimeout'],
        extends: PlyLearnBase,
        data() {
            return {
                answer: ''
            }
        },
        computed: {
            currentCard() {
                return this.cards[0] || null;
            }
        },
        methods: {
            nextCard(answerStatus) {
                setTimeout(() => {
                    const currentCard = this.cards.shift();

                    window.eventBus.$emit('cardChanged');

                    // Check type value
                    if (answerStatus === false) {
                        this.cards.push(currentCard);
                        return;
                    }

                    // Update progress
                    this.progressBar.setProgress(Math.round(100 * this.currentIndex / this.count));

                    // Check course progress
                    if(this.cards.length === 0) {
                        this.endLessonSuccess();
                    }
                }, this.cardTimeout);
            },
        },
        components: {
            PlyCardTyped
        }
    }
</script>

<style>
    #progressbar {
        width: 100%;
        height: 6px;
    }
</style>
