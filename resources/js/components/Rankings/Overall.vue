<template>
    <div class="ranking-container row mt-3">
        <div class="col-md-8">
            <draggable
                class="ranker p-2 mb-3"
                group="unit-ranking"
                :list="rankings"
            >
                <div
                    class="unit"
                    v-for="(element, index) in rankings"
                    :key="'ranked' + index"
                >
                    {{ index + 1 }} - {{ element.name }}
                    <button class="btn btn-link text-secondary float-right p-0 m-0" @click="removeUnit(index)">Remove</button>
                </div>
                <div slot="header" aria-label="Rank Placeholder">
                    <p class="placeholder" v-if="rankings.length === 0">
                        Drag and Drop Units here for Ranking!
                    </p>
                </div>
            </draggable>
        </div>
        <app-unit-search></app-unit-search>
    </div>
</template>

<style scoped>
.placeholder {
    color: #aaa;
}

.ranker {
    border: solid 1px #ccc;
    overflow-y: scroll;
    max-height: 550px;
    min-height: 550px;
}

.unit {
    cursor: move; /* fallback if grab cursor is unsupported */
    width: 98%;
    padding: 10px;
    border: solid 1px transparent;
    -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
    -khtml-user-select: none; /* Konqueror HTML */
    -moz-user-select: none; /* Old versions of Firefox */
    -ms-user-select: none; /* Internet Explorer/Edge */
    user-select: none; /* Non-prefixed version, currently supported by Chrome, Opera and Firefox */
}

.unit:hover {
    border: solid 1px black;
    border-radius: 5px;
}
</style>

<script>
import UnitSearch from "./UnitSearch";
import draggable from "vuedraggable";
export default {
    data() {
        return {
            rankings: [],
            search: ""
        };
    },
    methods:{
        removeUnit(unit){
            this.rankings.splice(unit,1)
        }
    },
    components: {
        draggable,
        "app-unit-search": UnitSearch
    }
};
</script>
