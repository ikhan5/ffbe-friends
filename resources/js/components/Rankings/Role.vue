<template>
    <div>
        <div class="row">
            <strong class="ml-2 mb-2"
                >Select the 5 best at each role and order them from 1 (best) to
                5 (5th best):</strong
            >

            <div class="ranking-container col-md-9 mt-3">
                <div v-if="step === 1" class="role-container">
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
                <div v-if="step === 1" class="role-container">
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
                <div v-if="step === 1" class="role-container">
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
                <div v-if="step === 1" class="role-container">
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
                <div v-if="step === 2" class="role-container">
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
                <div v-if="step === 2" class="role-container">
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
                <div v-if="step === 3" class="role-container">
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
                <div v-if="step === 3" class="role-container">
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
                <div v-if="step === 3" class="role-container">
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
            </div>
            <div class="col-md-3">
                <app-unit-search></app-unit-search>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col text-right">
                <button
                    v-if="!voted && step === 1"
                    class="btn btn-primary"
                    @click="submitDamageDealers"
                >
                    Submit Damage Dealer Rankings
                </button>
                <button
                    v-if="!voted && step === 2"
                    class="btn btn-primary"
                    @click="submitTanks"
                >
                    Submit Tank Rankings
                </button>
                <button
                    v-if="!voted && step === 3"
                    class="btn btn-primary"
                    @click="submitSupport"
                >
                    Submit Support Rankings
                </button>
                <button v-if="voted" class="btn btn-info" disabled>
                    User Has Voted
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
    cursor: move;
    width: 20%;
    padding: 2px;
    border: solid 1px transparent;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

.unit:hover {
    border: solid 1px black;
    border-radius: 5px;
}

.ranker {
    border: solid 1px #ccc;
    overflow-y: scroll;
    max-height: 100px;
    min-height: 100px;
}
</style>

<script>
import UnitSearch from "./UnitSearch";
import draggable from "vuedraggable";
import Swal from "sweetalert2";
import axios from "axios";

export default {
    data() {
        return {
            roleRankings: {},
            step: 1,
            physTanks: [],
            magTanks: [],
            provTanks: [],
            physDPS: [],
            magDPS: [],
            hybrids: [],
            finishers: [],
            healers: [],
            buffers: [],
            breakers: [],
            utility: [],
            voted: false
        };
    },
    created() {
        axios
            .get("/api/roleVote")
            .then(res => {
                if (res.data[0]) {
                    // this.voted = true;
                    this.physDPS = res.data[0].physDPS;
                    this.physTanks = res.data[0].physTanks;
                    this.magTanks = res.data[0].magTanks;
                    this.provTanks = res.data[0].provTanks;
                    this.magDPS = res.data[0].magDPS;
                    this.hybrids = res.data[0].hybrids;
                    this.finishers = res.data[0].finishers;
                    this.healers = res.data[0].healers;
                    this.buffers = res.data[0].buffers;
                    this.breakers = res.data[0].breakers;
                    this.utility = res.data[0].utility;
                } else {
                    this.voted = false;
                }
            })
            .catch(err => {
                Swal.fire(
                    "Error, Kupo!",
                    "There was an error on the server, please try again later!",
                    "error"
                );
            });
    },
    components: {
        draggable,
        "app-unit-search": UnitSearch
    },
    methods: {
        submitDamageDealers() {
            if (
                this.findDuplicates(this.physDPS) ||
                this.findDuplicates(this.magDPS) ||
                this.findDuplicates(this.hybrids) ||
                this.findDuplicates(this.finishers)
            ) {
                Swal.fire(
                    "Duplicates Detected",
                    "Please remove all duplicate values from within a certain role, i.e you cannot have a unit as the 1st and 2nd best Hybrid.",
                    "error"
                );
            } else if (
                this.checkBallotLengths(this.physDPS) ||
                this.checkBallotLengths(this.magDPS) ||
                this.checkBallotLengths(this.hybrids) ||
                this.checkBallotLengths(this.finishers)
            ) {
                Swal.fire(
                    "Invalid Ballot(s)",
                    "Please select 5 units per section.",
                    "error"
                );
            } else {
                this.updateBallot();
                Swal.fire({
                    title: "Are you ready to submit?",
                    text: "Preparing to submit Damage Dealers, submit now?",
                    type: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, submit!"
                }).then(result => {
                    if (result.value) {
                        axios
                            .patch("/api/updateRole", {
                                role: "damage",
                                physDPS: this.buffers,
                                magDPS: this.breakers,
                                hybrids: this.hybrids,
                                finishers: this.healers
                            })
                            .then(res => {
                                console.log(res.data);
                                Swal.fire(
                                    "Submitted!",
                                    "Proceeding to Tanks",
                                    "success"
                                );
                                this.step = 2;
                            })
                            .catch(err => {
                                console.log(err.response);
                                Swal.fire(
                                    "Error, Kupo!",
                                    "There was an error on the server submitting your ballot, please try again later!",
                                    "error"
                                );
                            });
                    }
                });
            }
        },
        submitTanks() {
            if (
                this.findDuplicates(this.physTanks) ||
                this.findDuplicates(this.magTanks)
            ) {
                Swal.fire(
                    "Duplicates Detected",
                    "Please remove all duplicate values from within a certain role, i.e you cannot have a unit as the 1st and 2nd best Hybrid.",
                    "error"
                );
            } else if (
                this.checkBallotLengths(this.physTanks) ||
                this.checkBallotLengths(this.magTanks)
            ) {
                Swal.fire(
                    "Invalid Ballot(s)",
                    "Please select 5 units per section.",
                    "error"
                );
            } else {
                this.updateBallot();
                Swal.fire({
                    title: "Are you ready to submit?",
                    text: "Preparing to submit Tanks, submit now?",
                    type: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, submit!"
                }).then(result => {
                    if (result.value) {
                        axios
                            .patch("/api/updateRole", {
                                role: "tank",
                                physTanks: this.physTanks,
                                magTanks: this.magTanks
                            })
                            .then(res => {
                                console.log(res.data);
                                Swal.fire(
                                    "Submitted!",
                                    "Proceeding to Support",
                                    "success"
                                );
                                this.step = 3;
                            })
                            .catch(err => {
                                console.log(err.response);
                                Swal.fire(
                                    "Error, Kupo!",
                                    "There was an error on the server submitting your ballot, please try again later!",
                                    "error"
                                );
                            });
                    }
                });
            }
        },
        submitSupport() {
            if (
                this.findDuplicates(this.healers) ||
                this.findDuplicates(this.buffers) ||
                this.findDuplicates(this.breakers)
            ) {
                Swal.fire(
                    "Duplicates Detected",
                    "Please remove all duplicate values from within a certain role, i.e you cannot have a unit as the 1st and 2nd best Hybrid.",
                    "error"
                );
            } else if (
                this.checkBallotLengths(this.healers) ||
                this.checkBallotLengths(this.buffers) ||
                this.checkBallotLengths(this.breakers)
            ) {
                Swal.fire(
                    "Invalid Ballot(s)",
                    "Please select 5 units per section.",
                    "error"
                );
            } else {
                this.updateBallot();
                Swal.fire({
                    title: "Are you ready to submit?",
                    text: "Preparing to submit Support, submit now?",
                    type: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, submit!"
                }).then(result => {
                    if (result.value) {
                        axios
                            .post("/api/rankings", {
                                ballot: this.roleRankings,
                                ballot_type: "role"
                            })
                            .then(res => {
                                Swal.fire(
                                    "Submitted!",
                                    "Your role rankings have been submitted!.",
                                    "success"
                                );
                            })
                            .catch(err => {
                                Swal.fire(
                                    "Error, Kupo!",
                                    "There was an error on the server submitting your ballot, please try again later!",
                                    "error"
                                );
                            });

                        axios
                            .patch("/api/updateRole", {
                                role: "support",
                                buffers: this.buffers,
                                breakers: this.breakers,
                                healers: this.healers
                            })
                            .then(res => {
                                console.log(res.data);
                            })
                            .catch(err => {
                                console.log(err.response);
                                Swal.fire(
                                    "Error, Kupo!",
                                    "There was an error on the server submitting your ballot, please try again later!",
                                    "error"
                                );
                            });
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
        },
        updateBallot() {
            this.roleRankings.physTanks = this.physTanks;
            this.roleRankings.magTanks = this.magTanks;
            this.roleRankings.physDPS = this.physDPS;
            this.roleRankings.magDPS = this.magDPS;
            this.roleRankings.hybrids = this.hybrids;
            this.roleRankings.finishers = this.finishers;
            this.roleRankings.healers = this.healers;
            this.roleRankings.buffers = this.buffers;
            this.roleRankings.breakers = this.breakers;
        },
        checkBallotLengths(input) {
            return input.length != 5;
        }
    }
};
</script>
