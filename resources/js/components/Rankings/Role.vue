<template>
    <div class="ranking-container row mt-3">
        <div class="col-md-8">
            <draggable
                class="ranker p-4"
                group="unit-ranking"
                :list="roleRankings"
            >
                <div
                    class="unit"
                    v-for="(element, index) in roleRankings"
                    :key="element.id"
                >
                    {{ index + 1 }} - {{ element.name }}
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

.ranker {
    border: solid 1px #ccc;
    overflow-y: scroll;
    max-height: 475px;
    min-height: 475px;
}
</style>

<script>
import UnitSearch from "./UnitSearch";
import draggable from "vuedraggable";
export default {
    data() {
        return {
            roleRankings: []
        };
    },
    components: {
        draggable,
        "app-unit-search": UnitSearch
    }
};
</script>
