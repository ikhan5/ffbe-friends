<template>
    <div>
        <h1 class="mb-4 mt-3">Unit Listings</h1>
        <div class="col-md-8 col-sm-12 my-5 mx-0 mx-auto">
            <input
                class="form-control"
                type="text"
                v-model="search"
                placeholder="Search Units..."
            />
        </div>
        <div class="d-md-flex float-right mb-4">
            <b-pagination
                v-model="currentPage"
                :total-rows="rows"
                :per-page="perPage"
                aria-controls="unitsTable"
                first-text="First"
                prev-text="Prev"
                next-text="Next"
                last-text="Last"
            ></b-pagination>
        </div>
        <b-table
            id="unitsTable"
            :items="filterUnits"
            :fields="fields"
            :busy="isLoading"
            :per-page="perPage"
            :current-page="currentPage"
            responsive="lg"
            show-empty
            caption-top
        >
            <template v-slot:table-caption
                >Login/Register to start adding Units</template
            >
            <template v-slot:cell(name)="data">
                <p>
                    <a target="_blank" :href="link + data.item.build"
                        >{{ data.item.name }} {{ data.item.rarity }}&#x2605;
                    </a>
                </p>
            </template>

            <template v-slot:empty="scope">
                <h4>{{ scope.emptyText }}</h4>
            </template>

            <template v-slot:empty="scope">
                <h4>{{ scope.emptyFilteredText }}</h4>
            </template>

            <template v-slot:cell(profile)="data">
                <p>
                    {{ data.item.profile.ign }}: <br />
                    {{ data.item.profile.friendCode | friendCode }}
                </p>
            </template>

            <template v-slot:cell(pevade)="data">
                {{ data.item.pevade }}%
            </template>

            <template v-slot:cell(magkillers)="data">
                <ul>
                    <template
                        v-for="(killers, key, index) in data.item.magkillers"
                    >
                        <li v-if="killers != 0" :key="index">
                            {{ key }}: <br />
                            {{ killers }}%
                        </li>
                    </template>
                </ul>
            </template>
            <template v-slot:cell(physkillers)="data">
                <ul>
                    <template
                        v-for="(killers, key, index) in data.item.physkillers"
                    >
                        <li v-if="killers != 0" :key="index">
                            {{ key }}: <br />
                            {{ killers }}%
                        </li>
                    </template>
                </ul>
            </template>
            <template v-slot:cell(status)="data">
                <ul>
                    <template v-for="(status, key, index) in data.item.status">
                        <li v-if="status != 0" :key="index">
                            {{ key }}: <br />
                            {{ status }}%
                        </li>
                    </template>
                </ul>
            </template>
            <template v-slot:cell(elemental)="data">
                <ul>
                    <template
                        v-for="(elemental, key, index) in data.item.elemental"
                    >
                        <li v-if="elemental != 0" :key="index">
                            {{ key }}: <br />
                            {{ elemental }}%
                        </li>
                    </template>
                </ul>
            </template>

            <template v-slot:cell(request)="data">
                <button
                    v-if="data.item.my_unit === 3"
                    class="btn btn-link ml-5"
                    @click="addNotify(data.item)"
                >
                    <i class="fas fa-plus-circle"></i>
                </button>
            </template>

            <template v-slot:table-busy>
                <div class="text-center text-danger my-2">
                    <b-spinner class="align-middle"></b-spinner>
                    <strong>Loading...</strong>
                </div>
            </template>
        </b-table>
    </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
export default {
    data() {
        return {
            perPage: 5,
            currentPage: 1,
            search: "",
            fields: [
                {
                    key: "name",
                    label: "Unit Name",
                    sortable: true
                },
                {
                    key: "hp",
                    label: "HP",
                    sortable: true
                },
                {
                    key: "mp",
                    label: "MP",
                    sortable: true
                },
                {
                    key: "atk",
                    label: "ATK",
                    sortable: true
                },
                {
                    key: "mag",
                    label: "MAG",
                    sortable: true
                },
                {
                    key: "def",
                    label: "DEF",
                    sortable: true
                },
                {
                    key: "spr",
                    label: "SPR",
                    sortable: true
                },
                {
                    key: "pevade",
                    label: "P.Evade",
                    sortable: true
                },
                {
                    key: "magkillers",
                    label: "M.Killers",
                    sortable: false
                },
                {
                    key: "physkillers",
                    label: "P.Killers",
                    sortable: false
                },
                {
                    key: "status",
                    label: "Status",
                    sortable: false
                },
                {
                    key: "elemental",
                    label: "Elemental",
                    sortable: false
                },
                {
                    key: "profile",
                    label: "Profile",
                    sortable: true
                },
                {
                    key: "request",
                    label: "Add",
                    sortable: false
                }
            ],

            link: "https://ffbeEquip.com/builder.html?server=GL#",
            units: [],
            isLoading: true
        };
    },
    beforeCreate() {
        this.isLoading = true;
    },
    created() {
        axios
            .get("/api/units")
            .then(res => {
                this.isLoading = false;
                this.units = res.data;
            })
            .catch(err => {
                Swal.fire(
                    "Error, Kupo!",
                    "There was an error whilst loading the units, please try again later",
                    "error"
                );
            });
    },
    computed: {
        filterUnits() {
            return this.units.filter(unit => {
                return unit.name.toLowerCase().match(this.search.toLowerCase());
            });
        },
        rows() {
            return this.filterUnits.length;
        }
    },
    methods: {
        addNotify(unit) {
            let id = parseInt(unit.user_id);
            axios
                .post("/api/notifications", {
                    receiving_id: id
                })
                .then(res => {
                    Swal.fire(
                        "Sending Add Notification",
                        "Notification sent successfully!",
                        "success"
                    );
                })
                .catch(err => {
                    Swal.fire(
                        "Error, Kupo!",
                        "There was an error whilst sending the notification, please try again later",
                        "error"
                    );
                });
        }
    }
};
</script>

<style scoped>
div {
    margin-top: 10px;
}

h1 {
    margin-bottom: 30px;
}

ul {
    list-style-type: none;
    padding-left: 0;
}

li {
    margin-bottom: 5px;
}
</style>
