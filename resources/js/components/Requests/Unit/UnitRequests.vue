<template>
    <div>
        <h1 class="mt-4">Request A Unit</h1>
        <div class="col clearfix">
            <button
                class="btn btn-outline-primary float-right"
                data-toggle="modal"
                data-target="#addRequest"
            >
                + Request A Unit
            </button>
        </div>
        <div class="mt-4">
            <div class="d-md-flex float-right mb-4">
                <b-pagination
                    v-model="currentPage"
                    :total-rows="rows"
                    :per-page="perPage"
                    aria-controls="requestsTable"
                    first-text="First"
                    prev-text="Prev"
                    next-text="Next"
                    last-text="Last"
                ></b-pagination>
            </div>
            <b-table
                id="requestsTable"
                :items="requests"
                :fields="fields"
                :busy="isLoading"
                :per-page="perPage"
                :current-page="currentPage"
                responsive
                show-empty
                caption-top
            >
                <template v-slot:table-caption
                    ><p>
                        Looking for a specific unit for a trial? Create a
                        request here!
                    </p>
                    <p>
                        Note: Active Requests can be managed in your profile,
                        and are active for 48 hours.
                    </p>
                </template>

                <template v-slot:cell(profile)="data">
                    <p class="mb-0">
                        {{ data.item.profile.ign }}: <br />
                        {{ data.item.profile.friendCode | friendCode }}
                        <span class="mb-0">
                            <p class="mb-0" v-if="data.item.profile.reddit">
                                {{ data.item.profile.reddit | reddit }}
                            </p>
                            <p v-if="data.item.profile.discord">
                                {{ data.item.profile.discord }}
                            </p>
                        </span>
                    </p>
                </template>

                <template v-slot:cell(killers)="data">
                    <ul>
                        <template v-for="(killers, index) in data.item.killers">
                            <li :key="'killer' + index">
                                {{ killers }}<span v-if="killers > 1">, </span>
                            </li>
                        </template>
                    </ul>
                </template>

                <template v-slot:cell(ailmentResists)="data">
                    <ul>
                        <template v-for="(status, index) in data.item.status">
                            <li :key="'status' + index">
                                {{ status
                                }}<span v-if="status.length > 1">, </span>
                            </li>
                        </template>
                    </ul>
                </template>

                <template v-slot:cell(elementalResists)="data">
                    <ul>
                        <template
                            v-for="(elemental, index) in data.item.elemental"
                        >
                            <li :key="'elem' + index">
                                {{
                                    elemental.element +
                                        " " +
                                        elemental.resist +
                                        "%"
                                }}<span v-if="elemental.length > 1">, </span>
                            </li>
                        </template>
                    </ul>
                </template>
                <template v-slot:table-busy>
                    <div class="text-center text-danger my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                    </div>
                </template>
            </b-table>
        </div>
        <div
            class="modal fade"
            id="addRequest"
            tabindex="-1"
            role="dialog"
            aria-labelledby="addRequestCenterTitle"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRequestLongTitle">
                            Looking for a(n)...
                            <span class="text-danger ml-4" v-if="errors">
                                {{ errorMsg }}
                            </span>
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <app-v-select
                                v-model="name"
                                :options="units"
                                label="name"
                                index="id"
                            >
                            </app-v-select>
                        </div>
                        <div class="form-group">
                            <label for="trial_name">Trial Name</label>
                            <app-v-select
                                id="trial_name"
                                v-model="trial_name"
                                :options="trials"
                            >
                            </app-v-select>
                        </div>
                        <div class="form-group">
                            <label for="weapon_elemental"
                                >With an Elemental Weapon of:</label
                            >
                            <select
                                id="weapon_elemental"
                                class="form-control"
                                v-model="weapon_ele"
                            >
                                <option value="Elementless" selected
                                    >No Element</option
                                >
                                <option
                                    v-for="(option, index) in elementalOptions"
                                    :key="'wepele' + index"
                                    :value="option"
                                    >{{ option }}</option
                                >
                                <option value="any">Any Element</option>
                                ></select
                            >
                        </div>
                        <div class="form-group mt-2">
                            <label for="">With the following killers:</label>
                            <br />
                            <template v-for="(option, index) in killerOptions">
                                <div
                                    class="form-check form-check-inline"
                                    :key="'killer' + index"
                                >
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        :id="option"
                                        :value="option"
                                        v-model="killers[index]"
                                    />
                                    <label
                                        class="form-check-label"
                                        :for="option"
                                        >{{ option }}</label
                                    >
                                </div>
                            </template>
                        </div>
                        <div class="form-group mt-2">
                            <label for="">The following ailment resists:</label>
                            <br />
                            <template v-for="(option, index) in statusOptions">
                                <div
                                    class="form-check form-check-inline"
                                    :key="'status' + index"
                                >
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        :id="option"
                                        :value="option"
                                        v-model="status[index]"
                                    />
                                    <label
                                        class="form-check-label"
                                        :for="option"
                                        >{{ option }}</label
                                    >
                                </div>
                            </template>
                        </div>
                        <div class="form-group mt-2">
                            <label for=""
                                >And elemental resists greater or equal to
                                (%):</label
                            >
                            <br />
                            <div class="row">
                                <template
                                    v-for="(option, index) in elementalOptions"
                                >
                                    <div
                                        class="col-md-3 mb-2"
                                        :key="'element' + index"
                                    >
                                        <label class="sr-only" :for="option">{{
                                            option
                                        }}</label>
                                        <input
                                            :id="option"
                                            class="form-control"
                                            :placeholder="option"
                                            v-model="elemental[index]"
                                        />
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="details">Additional Details:</label>
                            <textarea
                                id="details"
                                v-model="details"
                                class="form-control"
                                style="resize: none;"
                                placeholder="Ex. I need this unit for *trial name*, or need PeHP > 10000, etc. "
                                maxlength="100"
                            ></textarea>
                            <small>Max Chars. {{ details.length }}/100</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Close
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="addRequest"
                        >
                            Create Request
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
ul {
    list-style-type: none;
    padding-left: 0;
}
</style>

<script>
import Units from "../../../data/units.json";
import "vue-select/dist/vue-select.css";
import axios from "axios";
import Swal from "sweetalert2";
import Trials from "../../../data/trials.json";
export default {
    data() {
        return {
            perPage: 10,
            currentPage: 1,
            requests: [],
            units: [],
            trials: [],
            killers: [],
            elemental: [],
            status: [],
            name: "",
            trial_name: "",
            details: "",
            weapon_ele: "Elementless",
            isLoading: true,
            errors: false,
            errorMsg: "",
            fields: [
                {
                    key: "profile",
                    label: "Requesting User"
                },
                {
                    key: "trial_name",
                    label: "Trial Name"
                },
                {
                    key: "unit_name",
                    label: "Unit"
                },
                {
                    key: "weapon_ele",
                    label: "Elemental Weapon"
                },
                {
                    key: "killers",
                    label: "Killers"
                },
                {
                    key: "elementalResists",
                    label: "Elemental Resist"
                },
                {
                    key: "ailmentResists",
                    label: "Ailment Resist"
                },
                {
                    key: "details",
                    label: "Additional Details"
                }
            ],
            killerOptions: [
                "Aquatic",
                "Bird",
                "Beast",
                "Demon",
                "Dragon",
                "Fairy",
                "Human",
                "Insect",
                "Machine",
                "Plant",
                "Undead",
                "Stone"
            ],
            elementalOptions: [
                "Fire",
                "Ice",
                "Lightning",
                "Water",
                "Wind",
                "Earth",
                "Light",
                "Dark"
            ],
            statusOptions: [
                "Ribbon",
                "Poison",
                "Blind",
                "Sleep",
                "Paralyze",
                "Silence",
                "Confusion",
                "Disease",
                "Petrify",
                "Charm",
                "Stop",
                "Death"
            ]
        };
    },
    computed: {
        rows() {
            return this.requests.length;
        }
    },
    created() {
        for (let key in Units) {
            this.units.push({
                name: Units[key].name,
                id: key,
                rarity: Units[key].max_rarity
            });
        }
        this.units.sort((a, b) => (a.name > b.name ? 1 : -1));

        for (let key in Trials) {
            Trials[key].trials.forEach(trial => {
                this.trials.push(trial);
            });
        }
        this.getRequests();
    },
    methods: {
        getRequests() {
            axios
                .get("./api/unit_requests")
                .then(res => {
                    this.requests = res.data;
                    this.isLoading = false;
                })
                .catch(err => {
                    Swal.fire(
                        "Error Getting Requests",
                        "Error, Kupo! Problems trying to get requests. Please try again later.",
                        "error"
                    );
                });
        },
        addRequest() {
            let selectedKillers = [];
            let selectedStatus = [];
            let selectedElements = [];

            this.status.forEach((status, index) => {
                if (status) {
                    selectedStatus.push(this.statusOptions[index]);
                }
            });

            this.killers.forEach((killer, index) => {
                if (killer) {
                    selectedKillers.push(this.killerOptions[index]);
                }
            });

            this.elemental.forEach((percent, index) => {
                if (percent) {
                    selectedElements.push({
                        element: this.elementalOptions[index],
                        resist: percent
                    });
                }
            });

            axios
                .post("./api/unit_requests", {
                    unit_name: this.name.name,
                    weapon_ele: this.weapon_ele,
                    details: this.details,
                    killers: selectedKillers,
                    elemental: selectedElements,
                    status: selectedStatus,
                    trial_name: this.trial_name
                })
                .then(res => {
                    this.errors = false;
                    Swal.fire(
                        "Adding Request",
                        "Successfully added request for the unit",
                        "success"
                    );
                    this.getRequests();
                })
                .catch(err => {
                    if (err.response.data === 1) {
                        Swal.fire(
                            "Error Adding Requests",
                            "Players are allowed 2 Active Requests at a time. Please delete one and try again.",
                            "error"
                        );
                    } else if (err.response.data === 2) {
                        Swal.fire(
                            "Error Getting Requests",
                            "Error, Kupo! Problems trying to add request. Please try again later.",
                            "error"
                        );
                    } else {
                        this.errorMsg = "Please select a unit";
                    }
                    this.errors = true;
                });
        }
    }
};
</script>
