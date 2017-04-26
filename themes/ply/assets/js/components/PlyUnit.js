export default {
    props: ['course_id', 'unit_id'],
    data() {
        return {
            cards: [],
            current: 0
        }
    },
    created() {
        console.log(this);
        axios.get(`/learn/${this.course_id}/${this.unit_id}`).then(({data}) => {
            this.cards = data;
        });
    }
}