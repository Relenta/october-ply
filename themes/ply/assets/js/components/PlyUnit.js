export default {
  props: ['id'],
  data() {
    return {
      cards: [],
      current: 0
    }
  },
  created() {
    axios.get(`/learn/${this.id}`).then(({data}) => {
      this.cards = data;
    });
  },
}