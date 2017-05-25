import swal from 'sweetalert2'
import { playAudio } from '../helpers';
export default {
    data() {
        return {
            cards: [],
            current: 0
        }
    },
    mounted() {
        axios.get(`/api/v1/learn${location.search}`).then(({data}) => {
            this.cards = data.slice(0, 5);
        });
        let $vm = this;
        document.querySelector('#progressbar').addEventListener('mdl-componentupgraded', function() {
            this.MaterialProgress.setProgress(0);
            $vm.progressBar = this.MaterialProgress;
        });
    },
    methods: {
        endLessonSuccess() {
            swal('Great!', 'Lesson completed', 'success').then(() => {});
            playAudio('/themes/ply/dist/sounds/tada.mp3', 0);
        },
    }
}
