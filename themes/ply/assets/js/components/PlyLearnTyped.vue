<template>
    <div class="mdl-grid ply-learn-container">
        <ply-card-typed
            v-if="currentCard"
            :card="currentCard"
            @cardAnswered="nextCard"
            :sideTimeout="sideTimeout">
        </ply-card-typed>
        <div class="mdl-cell--4-col learn-sidebar">
            <div class="description mdl-shadow--2dp" style="background-image: url('/themes/ply/assets/images/bg-flags/uk.jpg');">
                <h1 class="course-title">Course title</h1>
                <div class="spacer"></div>
                <h2 class="unit-title">Unit title</h2>
            </div>
            <div class="progress-container">
                <h3>Your progress:</h3>
                <div id="progressbar" class="mdl-progress mdl-js-progress learn-progressbar"></div>
                <div class="percent"><span class="number">10</span>%</div>
            </div>
        </div>
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
