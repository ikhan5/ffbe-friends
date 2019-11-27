<template>
    <div>
        <h1 class="mb-4 mt-3">Unit Listings</h1>
        <div class="col-md-8 col-sm-12 mt-5 mb-3 mx-0 mx-auto">
            <input
                class="form-control"
                type="text"
                v-model="search"
                placeholder="Search Units or Usernames..."
                v-on:keydown.enter.prevent
            />
        </div>
        <div>
            <b-button v-b-toggle.advancedSearch variant="btn btn-link"
                >+ Advanced Search</b-button
            >
            <b-collapse id="advancedSearch">
                <hr />
                <p class="searchHeader">
                    Hide/Show Columns:
                </p>
                <div class="row">
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="element_weapon"
                            type="checkbox"
                            @change="show_hide('element_weapon')"
                            checked
                        />
                        Show Weapon Element</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="hp"
                            type="checkbox"
                            @change="show_hide('hp')"
                            checked
                        />
                        Show HP</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="mp"
                            type="checkbox"
                            @change="show_hide('mp')"
                            checked
                        />
                        Show MP</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="atk"
                            type="checkbox"
                            @change="show_hide('atk')"
                            checked
                        />
                        Show ATK</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="mag"
                            type="checkbox"
                            @change="show_hide('mag')"
                            checked
                        />
                        Show MAG</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="def"
                            type="checkbox"
                            @change="show_hide('def')"
                            checked
                        />
                        Show DEF</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="spr"
                            type="checkbox"
                            @change="show_hide('spr')"
                            checked
                        />
                        Show SPR</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="pevade"
                            type="checkbox"
                            @change="show_hide('pevade')"
                        />
                        Show Physical Evade</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="lb_damage"
                            type="checkbox"
                            @change="show_hide('lb_damage')"
                        />
                        Show LB Damage</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="magkillers"
                            type="checkbox"
                            @change="show_hide('magkillers')"
                        />
                        Show Killers</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="status"
                            type="checkbox"
                            @change="show_hide('status')"
                        />
                        Show Status Resists</label
                    >
                    <label class="col-md-2 col-sm-4 col-6"
                        ><input
                            class="elemental"
                            type="checkbox"
                            @change="show_hide('elemental')"
                        />
                        Show Element Resists</label
                    >
                </div>
                <hr />
                <p class="searchHeader">
                    Stat Restrictions:
                </p>
                <div class="row mt-2">
                    <div class="col-md-3 col-sm-6 col-12">
                        <label for="range-hp"
                            >HP greater than: {{ hpLimit }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-hp"
                            v-model.number="hpLimit"
                            type="range"
                            min="0"
                            step="1000"
                            max="30000"
                        ></b-form-input>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <label for="range-mp"
                            >MP greater than: {{ mpLimit }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-mp"
                            v-model.number="mpLimit"
                            type="range"
                            min="0"
                            step="100"
                            max="1300"
                        ></b-form-input>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <label for="range-atk"
                            >Attack greater than: {{ atkLimit }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-atk"
                            v-model.number="atkLimit"
                            type="range"
                            min="0"
                            step="250"
                            max="3500"
                        ></b-form-input>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <label for="range-mag"
                            >Magic greater than: {{ magLimit }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-mag"
                            v-model.number="magLimit"
                            type="range"
                            min="0"
                            step="250"
                            max="3250"
                        ></b-form-input>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <label for="range-def"
                            >Defense greater than: {{ defLimit }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-def"
                            v-model.number="defLimit"
                            type="range"
                            min="0"
                            step="250"
                            max="1750"
                        ></b-form-input>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <label for="range-spr"
                            >Spirit greater than: {{ sprLimit }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-spr"
                            v-model.number="sprLimit"
                            type="range"
                            min="0"
                            step="250"
                            max="2500"
                        ></b-form-input>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <label for="range-limit"
                            >LB greater than: {{ lbLimit }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-limit"
                            v-model.number="lbLimit"
                            type="range"
                            min="0"
                            step="50"
                            max="200"
                        ></b-form-input>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <label for="range-limit"
                            >Evade greater than: {{ evadeLimit }}</label
                        >
                        <b-form-input
                            class="mt-2"
                            id="range-limit"
                            v-model.number="evadeLimit"
                            type="range"
                            min="0"
                            step="25"
                            max="100"
                        ></b-form-input>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="mx-auto mx-0">
                        <b-button
                            v-b-toggle.advancedSearch
                            variant="btn btn-link"
                            >Close Search</b-button
                        >
                        <button
                            class="btn btn-outline-danger"
                            @click="resetFilters"
                        >
                            Reset Filters
                        </button>
                    </div>
                </div>
                <hr />
            </b-collapse>
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
            responsive
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
                <p>Slot: {{ data.item.slot }}</p>
            </template>

            <template v-slot:cell(profile)="data">
                <p class="mb-0">
                    {{ data.item.profile.ign }}: <br />
                    {{ data.item.profile.friendCode | friendCode }}
                </p>

                <span class="mb-0">
                    <p class="mb-0" v-if="data.item.profile.reddit">
                        {{ data.item.profile.reddit | reddit }}
                    </p>
                    <p v-if="data.item.profile.discord">
                        {{ data.item.profile.discord }}
                    </p>
                </span>
            </template>

            <template v-slot:empty="scope">
                <h4>{{ scope.emptyText }}</h4>
            </template>

            <template v-slot:empty="scope">
                <h4>{{ scope.emptyFilteredText }}</h4>
            </template>

            <template v-slot:cell(element_weapon)="data">
                <p>
                    {{
                        data.item.element_weapon === "" ||
                        data.item.element_weapon === "Elementless"
                            ? "No Element"
                            : data.item.element_weapon
                    }}
                </p>
            </template>

            <template v-slot:cell(pevade)="data">
                {{ data.item.pevade }}%
            </template>

            <template v-slot:cell(lb_damage)="data">
                {{ data.item.lb_damage === "" ? 0 : data.item.lb_damage }}%
            </template>

            <template v-slot:cell(magkillers)="data">
                <ul>
                    <b-button
                        v-b-toggle="'collapse-physkillers' + data.item.id"
                        variant="primary"
                        >Physical</b-button
                    >
                    <b-collapse
                        :id="'collapse-physkillers' + data.item.id"
                        class="mt-2"
                    >
                        <template
                            v-for="(killers, key, index) in data.item
                                .physkillers"
                        >
                            <li v-if="killers != 0" :key="'phys' + index">
                                {{ key | capitalize }}: {{ killers }}%
                            </li>
                        </template>
                    </b-collapse>
                    <hr />
                    <b-button
                        v-b-toggle="'collapse-magkillers' + data.item.id"
                        variant="success"
                        >Magical</b-button
                    >
                    <b-collapse
                        :id="'collapse-magkillers' + data.item.id"
                        class="mt-2"
                    >
                        <template
                            v-for="(killers, key, index) in data.item
                                .magkillers"
                        >
                            <li v-if="killers != 0" :key="'mag' + index">
                                {{ key | capitalize }}: {{ killers }}%
                            </li>
                        </template>
                    </b-collapse>
                </ul>
            </template>
            <template v-slot:cell(status)="data">
                <ul>
                    <template v-for="(status, key, index) in data.item.status">
                        <li v-if="status != 0" :key="'status' + index">
                            {{ key | capitalize }}:
                            {{ status > 100 ? 100 : status }}%
                        </li>
                    </template>
                </ul>
            </template>
            <template v-slot:cell(elemental)="data">
                <ul>
                    <template
                        v-for="(elemental, key, index) in data.item.elemental"
                    >
                        <li v-if="elemental != 0" :key="'elem' + index">
                            {{ key | capitalize }}: {{ elemental }}%
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
            hpLimit: 0,
            mpLimit: 0,
            atkLimit: 0,
            defLimit: 0,
            magLimit: 0,
            sprLimit: 0,
            lbLimit: 0,
            evadeLimit: 0,
            ribbon: false,
            fields: [
                {
                    key: "name",
                    label: "Unit Name",
                    sortable: true
                },
                {
                    key: "profile",
                    label: "Profile",
                    sortable: false
                },
                {
                    key: "element_weapon",
                    label: "Element(s)",
                    sortable: true,
                    thClass: "",
                    tdClass: ""
                },
                {
                    key: "hp",
                    label: "HP",
                    sortable: true,
                    thClass: "",
                    tdClass: ""
                },
                {
                    key: "mp",
                    label: "MP",
                    sortable: true,
                    thClass: "",
                    tdClass: ""
                },
                {
                    key: "atk",
                    label: "ATK",
                    sortable: true,
                    thClass: "",
                    tdClass: ""
                },
                {
                    key: "mag",
                    label: "MAG",
                    sortable: true,
                    thClass: "",
                    tdClass: ""
                },
                {
                    key: "def",
                    label: "DEF",
                    sortable: true,
                    thClass: "",
                    tdClass: ""
                },
                {
                    key: "spr",
                    label: "SPR",
                    sortable: true,
                    thClass: "",
                    tdClass: ""
                },
                {
                    key: "pevade",
                    label: "P.Evade",
                    sortable: true,
                    thClass: "d-none",
                    tdClass: "d-none",
                    defaultCol: false
                },
                {
                    key: "lb_damage",
                    label: "LB",
                    sortable: true,
                    thClass: "d-none",
                    tdClass: "d-none",
                    defaultCol: false
                },
                {
                    key: "magkillers",
                    label: "Killers",
                    sortable: false,
                    colspan: 3,
                    thClass: "d-none",
                    tdClass: "d-none",
                    defaultCol: false
                },
                {
                    key: "status",
                    label: "Status",
                    sortable: false,
                    thClass: "d-none",
                    tdClass: "d-none",
                    defaultCol: false
                },
                {
                    key: "elemental",
                    label: "Elemental",
                    sortable: false,
                    thClass: "d-none",
                    tdClass: "d-none",
                    defaultCol: false
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
                let unitName = unit.name
                    .toLowerCase()
                    .match(this.search.toLowerCase());
                let inGameName = unit.profile.ign
                    .toLowerCase()
                    .match(this.search.toLowerCase());
                let attackLimit = unit.atk >= this.atkLimit;
                let magicLimit = unit.mag >= this.magLimit;
                let defenseLimit = unit.def >= this.defLimit;
                let spiritLimit = unit.spr >= this.sprLimit;
                let healthLimit = unit.hp >= this.hpLimit;
                let manaLimit = unit.mp >= this.mpLimit;
                let limitLimit = unit.lb_damage >= this.lbLimit;
                let evadeLimit = unit.pevade >= this.evadeLimit;

                return (
                    (unitName || inGameName) &&
                    attackLimit &&
                    magicLimit &&
                    defenseLimit &&
                    spiritLimit &&
                    healthLimit &&
                    manaLimit &&
                    evadeLimit &&
                    limitLimit
                );
            });
        },
        rows() {
            return this.filterUnits.length;
        }
    },
    methods: {
        show_hide(colName) {
            this.fields.filter(col => {
                if (col.key === colName) {
                    if (col.thClass === "" && col.tdClass === "") {
                        col.thClass = "d-none";
                        col.tdClass = "d-none";
                    } else {
                        col.thClass = "";
                        col.tdClass = "";
                    }
                }
            });
        },
        resetFilters() {
            this.fields.forEach(col => {
                if (col.defaultCol === false) {
                    document.querySelector("." + col.key).checked = false;
                    col.thClass = "d-none";
                    col.tdClass = "d-none";
                }
            });
            this.hpLimit = 0;
            this.mpLimit = 0;
            this.atkLimit = 0;
            this.defLimit = 0;
            this.magLimit = 0;
            this.sprLimit = 0;
            this.lbLimit = 0;
            this.evadeLimit = 0;
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
    font-size: 0.95em;
}

.killers {
    width: 120px;
}

.searchHeader {
    font-weight: bold;
}
</style>
