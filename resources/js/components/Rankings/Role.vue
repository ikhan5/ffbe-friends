<template>
    <div>
        <div class="row">
            <strong class="ml-2 mb-2"
                >Select the 5 best at each role and order them from 1 (best) to
                5 (5th best):</strong
            >
            <div class="ranking-container col-md-9 mt-3">
                <div class="role-container">
                    <h2>Physical Chainers</h2>
                    <draggable
                        class="ranker row p-2"
                        group="unit-ranking"
                        :list="physDPS"
                    >
                        <div
                            class="unit"
                            v-for="(element, index) in physDPS"
                            :key="element.id"
                        >
                            {{ index + 1 }} - {{ element.name }}
                            <button
                                class="btn btn-link text-danger float-right p-0 m-0"
                                @click="physDPS.splice(index, 1)"
                            >
                                X
                            </button>
                        </div>

                        <div slot="header" aria-label="Rank Placeholder">
                            <p class="placeholder" v-if="physDPS.length === 0">
                                Drag and Drop 5 Physical Chainers here for
                                Ranking!
                            </p>
                        </div>
                    </draggable>
                </div>
                <div class="role-container">
                    <h2>Magical Chainers</h2>
                    <draggable
                        class="ranker row p-2"
                        group="unit-ranking"
                        :list="magDPS"
                    >
                        <div slot="header" aria-label="Rank Placeholder">
                            <p class="placeholder" v-if="magDPS.length === 0">
                                Drag and Drop 5 Magical Chainers here for
                                Ranking!
                            </p>
                        </div>
                        <div
                            class="unit"
                            v-for="(element, index) in magDPS"
                            :key="element.id"
                        >
                            {{ index + 1 }} - {{ element.name }}
                            <button
                                class="btn btn-link text-danger float-right p-0 m-0"
                                @click="magDPS.splice(index, 1)"
                            >
                                X
                            </button>
                        </div>
                    </draggable>
                </div>
                <div class="role-container">
                    <h2>Hybrid Chainers</h2>
                    <draggable
                        class="ranker row p-2"
                        group="unit-ranking"
                        :list="hybrids"
                    >
                        <div slot="header" aria-label="Rank Placeholder">
                            <p class="placeholder" v-if="hybrids.length === 0">
                                Drag and Drop 5 Hybrid Chainers here for
                                Ranking!
                            </p>
                        </div>
                        <div
                            class="unit"
                            v-for="(element, index) in hybrids"
                            :key="element.id"
                        >
                            {{ index + 1 }} - {{ element.name }}
                            <button
                                class="btn btn-link text-danger float-right p-0 m-0"
                                @click="hybrids.splice(index, 1)"
                            >
                                X
                            </button>
                        </div>
                    </draggable>
                </div>
                <div class="role-container">
                    <h2>Finishers (Mag or Phys)</h2>
                    <draggable
                        class="ranker row p-2"
                        group="unit-ranking"
                        :list="finishers"
                    >
                        <div slot="header" aria-label="Rank Placeholder">
                            <p
                                class="placeholder"
                                v-if="finishers.length === 0"
                            >
                                Drag and Drop 5 Finishers here for Ranking!
                            </p>
                        </div>
                        <div
                            class="unit"
                            v-for="(element, index) in finishers"
                            :key="element.id"
                        >
                            {{ index + 1 }} - {{ element.name }}
                            <button
                                class="btn btn-link text-danger float-right p-0 m-0"
                                @click="finishers.splice(index, 1)"
                            >
                                X
                            </button>
                        </div>
                    </draggable>
                </div>
                <div class="role-container">
                    <h2>Physical Cover Tanks</h2>
                    <draggable
                        class="ranker row p-2"
                        group="unit-ranking"
                        :list="physTanks"
                    >
                        <div slot="header" aria-label="Rank Placeholder">
                            <p
                                class="placeholder"
                                v-if="physTanks.length === 0"
                            >
                                Drag and Drop 5 Physical Tanks here for Ranking!
                            </p>
                        </div>
                        <div
                            class="unit"
                            v-for="(element, index) in physTanks"
                            :key="element.id"
                        >
                            {{ index + 1 }} - {{ element.name }}
                            <button
                                class="btn btn-link text-danger float-right p-0 m-0"
                                @click="physTanks.splice(index, 1)"
                            >
                                X
                            </button>
                        </div>
                    </draggable>
                </div>
                <div class="role-container">
                    <h2>Magic Cover Tanks</h2>
                    <draggable
                        class="ranker row p-2"
                        group="unit-ranking"
                        :list="magTanks"
                    >
                        <div slot="header" aria-label="Rank Placeholder">
                            <p class="placeholder" v-if="magTanks.length === 0">
                                Drag and Drop 5 Magic Tanks here for Ranking!
                            </p>
                        </div>
                        <div
                            class="unit"
                            v-for="(element, index) in magTanks"
                            :key="element.id"
                        >
                            {{ index + 1 }} - {{ element.name }}
                            <button
                                class="btn btn-link text-danger float-right p-0 m-0"
                                @click="magTanks.splice(index, 1)"
                            >
                                X
                            </button>
                        </div>
                    </draggable>
                </div>
                <div class="role-container">
                    <h2>Provoke Tanks</h2>
                    <draggable
                        class="ranker row p-2"
                        group="unit-ranking"
                        :list="provTanks"
                    >
                        <div slot="header" aria-label="Rank Placeholder">
                            <p
                                class="placeholder"
                                v-if="provTanks.length === 0"
                            >
                                Drag and Drop 5 Provoke Tanks here for Ranking!
                            </p>
                        </div>
                        <div
                            class="unit"
                            v-for="(element, index) in provTanks"
                            :key="element.id"
                        >
                            {{ index + 1 }} - {{ element.name }}
                            <button
                                class="btn btn-link text-danger float-right p-0 m-0"
                                @click="provTanks.splice(index, 1)"
                            >
                                X
                            </button>
                        </div>
                    </draggable>
                </div>
                <div class="role-container">
                    <h2>Support: Healers</h2>
                    <draggable
                        class="ranker row p-2"
                        group="unit-ranking"
                        :list="healers"
                    >
                        <div slot="header" aria-label="Rank Placeholder">
                            <p class="placeholder" v-if="healers.length === 0">
                                Drag and Drop 5 Healers here for Ranking!
                            </p>
                        </div>
                        <div
                            class="unit"
                            v-for="(element, index) in healers"
                            :key="element.id"
                        >
                            {{ index + 1 }} - {{ element.name }}
                            <button
                                class="btn btn-link text-danger float-right p-0 m-0"
                                @click="healers.splice(index, 1)"
                            >
                                X
                            </button>
                        </div>
                    </draggable>
                </div>
                <div class="role-container">
                    <h2>Support: Buffers</h2>
                    <draggable
                        class="ranker row p-2"
                        group="unit-ranking"
                        :list="buffers"
                    >
                        <div slot="header" aria-label="Rank Placeholder">
                            <p class="placeholder" v-if="buffers.length === 0">
                                Drag and Drop 5 Buffers here for Ranking!
                            </p>
                        </div>
                        <div
                            class="unit"
                            v-for="(element, index) in buffers"
                            :key="element.id"
                        >
                            {{ index + 1 }} - {{ element.name }}
                            <button
                                class="btn btn-link text-danger float-right p-0 m-0"
                                @click="buffers.splice(index, 1)"
                            >
                                X
                            </button>
                        </div>
                    </draggable>
                </div>
                <div class="role-container">
                    <h2>Support: Breakers</h2>
                    <draggable
                        class="ranker row p-2"
                        group="unit-ranking"
                        :list="breakers"
                    >
                        <div slot="header" aria-label="Rank Placeholder">
                            <p class="placeholder" v-if="breakers.length === 0">
                                Drag and Drop 5 Breakers here for Ranking!
                            </p>
                        </div>
                        <div
                            class="unit"
                            v-for="(element, index) in breakers"
                            :key="element.id"
                        >
                            {{ index + 1 }} - {{ element.name }}
                            <button
                                class="btn btn-link text-danger float-right p-0 m-0"
                                @click="breakers.splice(index, 1)"
                            >
                                X
                            </button>
                        </div>
                    </draggable>
                </div>
                <div class="role-container">
                    <h2>Utility: "Jack of All Trades"</h2>
                    <draggable
                        class="ranker row p-2"
                        group="unit-ranking"
                        :list="utility"
                    >
                        <div slot="header" aria-label="Rank Placeholder">
                            <p class="placeholder" v-if="utility.length === 0">
                                Drag and Drop 5 Utility Units here for Ranking!
                            </p>
                        </div>
                        <div
                            class="unit"
                            v-for="(element, index) in utility"
                            :key="element.id"
                        >
                            {{ index + 1 }} - {{ element.name }}
                            <button
                                class="btn btn-link text-danger float-right p-0 m-0"
                                @click="utility.splice(index, 1)"
                            >
                                X
                            </button>
                        </div>
                    </draggable>
                </div>
            </div>
            <div class="col-md-3">
                <app-unit-search></app-unit-search>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col text-right">
                <button class="btn btn-primary" @click="submitRoleRankings">
                    Submit Role Rankings
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.placeholder {
    color: #aaa;
}

.role-container {
    margin-bottom: 15px;
}

.role-container > h2 {
    font-size: 1.2em;
}

.unit {
    cursor: move; /* fallback if grab cursor is unsupported */
    width: 20%;
    padding: 2px;
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
    max-height: 60px;
    min-height: 60px;
}
</style>

<script>
import UnitSearch from "./UnitSearch";
import draggable from "vuedraggable";
import Swal from "sweetalert2";

export default {
    data() {
        return {
            roleRankings: [],
            physTanks: [] /**/,
            magTanks: [] /**/,
            provTanks: [] /**/,
            physDPS: [] /**/,
            magDPS: [] /**/,
            hybrids: [] /**/,
            finishers: [] /**/,
            healers: [] /**/,
            buffers: [] /**/,
            breakers: [] /**/,
            utility: []
        };
    },
    components: {
        draggable,
        "app-unit-search": UnitSearch
    },
    methods: {
        submitRoleRankings() {
            if (
                this.findDuplicates(this.physTanks) ||
                this.findDuplicates(this.magTanks) ||
                this.findDuplicates(this.provTanks) ||
                this.findDuplicates(this.physDPS) ||
                this.findDuplicates(this.magDPS) ||
                this.findDuplicates(this.hybrids) ||
                this.findDuplicates(this.finishers) ||
                this.findDuplicates(this.healers) ||
                this.findDuplicates(this.buffers) ||
                this.findDuplicates(this.breakers) ||
                this.findDuplicates(this.utility)
            ) {
                Swal.fire(
                    "Duplicates Detected",
                    "Please remove all duplicate values from within a certain role, i.e you cannot have a unit as the 1st and 2nd best Hybrid.",
                    "error"
                );
            } else {
                Swal.fire({
                    title: "Are you ready to submit?",
                    text: "Preparing to submit Role Rankings, submit now?",
                    type: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, submit!"
                }).then(result => {
                    if (result.value) {
                        Swal.fire(
                            "Submitted!",
                            "Your role rankings have been submitted! You can update your rankings at any time; however, it counts as one submission, overall.",
                            "success"
                        );
                    }
                });
            }
        },
        findDuplicates(input) {
            var duplicates = input.reduce(function(acc, el, i, arr) {
                if (arr.indexOf(el) !== i && acc.indexOf(el) < 0) acc.push(el);
                return acc;
            }, []);

            return duplicates.length > 0 ? true : false;
        }
    }
};
</script>
