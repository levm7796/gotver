import { createStore } from 'vuex';

const store = createStore({
    state() {
        return {
            selected_location: null,
            selected_hub: null,
        };
    },
    mutations: {
        setSelectedLocation(state, value) {
            state.selected_location = value;
        },
        setSelectedHub(state, value) {
            state.selected_Hub = value;
        },
    },
    actions: {
        setSelectedLocation(context, value) {
            context.commit('setSelectedLocation', value);
        },
        setSelectedHub(context, value) {
            context.commit('setSelectedHub', value);
        },
    },
    getters: {
        getSelectedLocation: state => state.selected_location,
        getSelectedHub: state => state.selected_hub,
    }
});

export default store;
