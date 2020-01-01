<template>
    <div>
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
                        <button
                            class="btn btn-link text-secondary float-right p-0 m-0"
                            @click="removeUnit(index)"
                        >
                            Remove
                        </button>
                    </div>
                    <div slot="header" aria-label="Rank Placeholder">
                        <p class="placeholder" v-if="rankings.length === 0">
                            Drag and Drop Units here for Ranking!
                        </p>
                    </div>
                </draggable>
            </div>
            <div class="col-md-4">
                <app-unit-search></app-unit-search>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col text-right">
                <button
                    v-if="!voted"
                    class="btn btn-primary"
                    @click="submitOverallRankings"
                >
                    Submit Top 15 Rankings
                </button>
                <button v-else class="btn btn-info" disabled>
                    User Has Voted
                </button>
            </div>
        </div>
        <div class="col">
            <h3>REFERENCES</h3>
            <ul>
                <li>
                    <a
                        target="_blank"
                        href="https://brave-exvius.com/threads/memel0rds-unit-rankings.15685/"
                        >Memel0rd Unit Rankings</a
                    >
                </li>
                <li>
                    <a
                        target="_blank"
                        href="https://exvius.gamepedia.com/Unit_Rankings"
                        >FFBE Wiki Rankings</a
                    >
                </li>
            </ul>
        </div>
    </div>
</template>

<style scoped>
.placeholder {
    color: #aaa;
}

.ranker {
    border: solid 1px #ccc;
    overflow-y: scroll;
    max-height: 700px;
    min-height: 700px;
}

.unit {
    cursor: move;
    width: 98%;
    padding: 10px;
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

ul {
    list-style: none;
}
li {
    margin-left: -25px;
}
</style>

<script>
import UnitSearch from "./UnitSearch";
import draggable from "vuedraggable";
import Swal from "sweetalert2";
import axios from "axios";
import Loading from "../Spinner";

export default {
    data() {
        return {
            rankings: [],
            search: "",
            voted: false
        };
    },
    created() {
        axios
            .get("/api/overallVote")
            .then(res => {
                if (res.data[0]) {
                    this.voted = true;
                    res.data[0].forEach(unit => {
                        this.rankings.push(unit);
                    });
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
    methods: {
        removeUnit(unit) {
            this.rankings.splice(unit, 1);
        },
        findDuplicates(input) {
            var duplicates = input.reduce(function(acc, el, i, arr) {
                if (arr.indexOf(el) !== i && acc.indexOf(el) < 0) acc.push(el);
                return acc;
            }, []);

            return duplicates.length > 0 ? true : false;
        },
        submitOverallRankings() {
            if (this.findDuplicates(this.rankings)) {
                Swal.fire(
                    "Duplicates Detected",
                    "Please remove all duplicate values from within a certain role, i.e you cannot have Sylvie as the 1st, 2nd and 3rd best unit.",
                    "error"
                );
            } else if (this.rankings.length < 15) {
                Swal.fire(
                    "Ranking not complete!",
                    "Please choose 15 units for a complete ranking.",
                    "error"
                );
            } else {
                Swal.fire({
                    title: "Are you ready to submit?",
                    text:
                        "Once submitted you CANNOT vote again, submit anyway?",
                    type: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, submit!"
                }).then(result => {
                    if (result.value && !this.voted) {
                        axios
                            .post("/api/rankings", {
                                ballot: this.rankings,
                                ballot_type: "overall"
                            })
                            .then(res => {
                                this.voted = true;
                                Swal.fire(
                                    "Submitted!",
                                    "Your overall rankings have been submitted! The Overall Results will be released at another time.",
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
                            .patch("/api/updateOverall", {
                                unit: this.rankings
                            })
                            .then(res => {})
                            .catch(err => {
                                Swal.fire(
                                    "Error, Kupo!",
                                    "There was an error on the server submitting your ballot, please try again later!",
                                    "error"
                                );
                            });
                    }
                });
            }
        }
    },
    components: {
        draggable,
        "app-unit-search": UnitSearch
    }
};
</script>
