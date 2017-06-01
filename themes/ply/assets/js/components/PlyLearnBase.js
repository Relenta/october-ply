import axios from 'axios';
import swal from 'sweetalert2';
import {playAudio} from '../helpers';

export default {
    data() {
        return {
            cards: [],
            current: 0,
            count: 0
        }
    },
    mounted() {
        axios.get(`/api/v1/learn${location.search}`).then(({data}) => {
            this.cards = data;
            this.count = data.length;
        });
        let $vm = this;
        document.querySelector('#progressbar').addEventListener('mdl-componentupgraded', function () {
            this.MaterialProgress.setProgress(0);
            $vm.progressBar = this.MaterialProgress;
        });
    },
    methods: {
        endLessonSuccess() {
            swal({
                title: 'Great!',
                text: 'Lesson completed',
                type: 'success',
                timer: 2000
            }).then(this.redirectHome, this.redirectHome).catch(this.redirectHome);
            playAudio('/themes/ply/dist/sounds/tada.mp3', 0);
        },
        redirectHome() {
            window.location = '/account/subscriptions';
        }
    }
}
