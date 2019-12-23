<template>
    <div class="col-md-4">
        <input
            class="form-control mb-2"
            type="text"
            v-model="search"
            placeholder="Search Units..."
            v-on:keydown.enter.prevent
        />
        <draggable
            class="units"
            :list="findUnit"
            :group="{ name: 'unit-ranking', pull: 'clone', put: false }"
        >
            <transition-group>
                <div
                    class="unit"
                    v-for="(unit, index) in findUnit"
                    :key="'ranking' + index"
                >
                    {{ unit.name }}
                </div>
            </transition-group>
        </draggable>
    </div>
</template>

<style scoped>
.units {
    max-height: 650px;
    overflow-y: scroll;
    list-style: none;
}

.unit {
    cursor: move; /* fallback if grab cursor is unsupported */
    width: 98%;
    padding: 5px;
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
import draggable from "vuedraggable";
import Units from "../../data/rankedUnits.json";
export default {
    data() {
        return {
            units: [],
            search: ""
        };
    },
    created() {
        for (let key in Units.units) {
            this.units.push({
                name: Units.units[key]
            });
        }
        this.units.sort((a, b) => (a.name > b.name ? 1 : -1));
    },
    computed: {
        findUnit() {
            return this.units.filter(unit => {
                return unit.name.toLowerCase().match(this.search.toLowerCase());
            });
        }
    },
    components: {
        draggable
    }
};
</script>
