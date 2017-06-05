<template>
    <div class="mdl-grid ply-learn-container">
        <ply-card-flash
            v-if="currentCard"
            :card="currentCard"
            @cardAnswered="nextCard"
            :sideTimeout="sideTimeout">
            <!-- :sideTimeout="1"> -->
        </ply-card-flash>
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
                    var _percent = Math.round(100 * this.currentIndex / this.count);
                    console.log($(this));
                    this.progressBar.setProgress(_percent);

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