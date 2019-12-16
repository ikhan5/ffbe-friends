<template>
    <div>
        <h1 class="mt-4">Add Your Unit</h1>
        <p class="mb-4 incomplete">
            Make sure to complete
            <router-link to="/profile" tag="a">Your Profile</router-link> before
            adding a unit
        </p>
        <hr />
        <form>
            <div class="form-group mb-2">
                <h3 class="find-header">Find Unit Using Build ID</h3>
                <h3 v-if="empty" class="text-danger error-msg">
                    Please enter the Build ID.
                </h3>
                <label for="name" class="my-3">Build URL</label>
                <div class="form-row">
                    <div class="col-md-5 col-12">
                        <input
                            readonly
                            type="text"
                            class="form-control-plaintext ml-md-3"
                            id="staticEmail"
                            value="ffbeEquip.com/builder.html?server=GL#"
                        />
                    </div>
                    <div class="col-md-6 col-12">
                        <input
                            v-model="buildURL"
                            type="text"
                            class="form-control"
                            id="name"
                            placeholder="63304e00-f44d-11e9-8f21-29aab363c1db"
                            aria-describedby="buildUrlBlock"
                        />
                        <small id="buildUrlBlock" class="form-text text-muted">
                            The Link can be found under 'Share this Build > FFBE
                            Equip link (this unit only)' on
                            <a href="https://ffbeequip.com/builder.html"
                                >FFBE Equip</a
                            >. Please avoid using external percentage buffs.
                        </small>
                    </div>
                </div>
                <div class="form-group">
                    <div class="text-md-right mt-5">
                        <button
                            class="btn btn-primary"
                            @click.prevent="fillForm"
                        >
                            Find Unit
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <hr />
                <div v-if="errors">
                    <h3 v-if="!loggedIn" class="text-danger error-msg">
                        Error adding unit. {{ errorMsg }}
                    </h3>
                </div>
                <app-loading v-if="isLoading"></app-loading>
                <div v-if="notFound">
                    <h3 class="text-danger">
                        Cannot Find Unit! Double check your build ID and try
                        again
                    </h3>
                </div>
                <div v-if="buffed">
                    <h3 class="text-danger">
                        Please remove all external percentage buffs from your
                        unit.
                    </h3>
                </div>
                <template v-if="unitFound">
                    <template>
                        <h3 class="mb-3">Unit Info</h3>
                        <div class="panel panel-default">
                            <div class="panel-heading mb-3">
                                <strong>{{ name }} {{ rarity }}&#x2605;</strong>
                            </div>
                            <div class="panel-body">
                                <div class="form-group row">
                                    <label class="col-md-2" for="slotNum"
                                        >Slot #:</label
                                    >
                                    <select
                                        class="form-control col-md-5"
                                        v-model="slot"
                                        id="slotNum"
                                    >
                                        <option
                                            v-for="(slotOption,
                                            index) in slotOptions"
                                            :key="'slot' + index"
                                            :value="slotOption"
                                            >{{ slotOption }}</option
                                        >
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2" for="trial_name">Geared For (optional):</label>
                                    <app-v-select
                                    class="col-md-5 px-0"
                                        id="trial_name"
                                        v-model="buildType"
                                        :options="trials"
                                    >
                                    </app-v-select>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2"
                                        >Weapon Element(s):</label
                                    >
                                    <template
                                        v-for="(eleWeapon,
                                        index) in elementWeapons"
                                    >
                                        <p
                                            class="mr-2"
                                            :key="'eleweapon' + index"
                                        >
                                            {{ eleWeapon }}
                                        </p>
                                    </template>
                                </div>

                                <div class="form-row">
                                    <ul class="col-md-2 col-sm-4 col-6">
                                        <span class="column-header"
                                            >Base Stats:
                                        </span>
                                        <li>Health: {{ hp }}</li>
                                        <li>Mana: {{ mp }}</li>
                                        <li>Atack: {{ atk }}</li>
                                        <li>Defense: {{ def }}</li>
                                        <li>Magic: {{ mag }}</li>
                                        <li>Spirit: {{ spr }}</li>
                                        <li>P.Evasion: {{ evade }}%</li>
                                        <li>LB Damage: {{ lb_damage }}%</li>
                                    </ul>
                                    <ul class="col-md-2 col-sm-4 col-6">
                                        <span class="column-header"
                                            >Status Resist:</span
                                        >
                                        <template
                                            v-for="(resist,
                                            key,
                                            index) in status"
                                        >
                                            <li
                                                v-if="resist !== 0"
                                                :key="index"
                                            >
                                                {{ key | capitalize }}:
                                                {{ resist }}%
                                            </li>
                                        </template>
                                    </ul>
                                    <ul class="col-md-2 col-sm-4 col-6">
                                        <span class="column-header"
                                            >Physical Killers:</span
                                        >
                                        <template
                                            v-for="(killer,
                                            key,
                                            index) in physkillers"
                                        >
                                            <li
                                                v-if="killer !== 0"
                                                :key="index"
                                            >
                                                {{ key | capitalize }}:
                                                {{ killer }}%
                                            </li>
                                        </template>
                                    </ul>
                                    <ul class="col-md-2 col-sm-4 col-6">
                                        <span class="column-header"
                                            >Magic Killers:</span
                                        >
                                        <template
                                            v-for="(killer,
                                            key,
                                            index) in magkillers"
                                        >
                                            <li
                                                v-if="killer !== 0"
                                                :key="index"
                                            >
                                                {{ key | capitalize }}:
                                                {{ killer }}%
                                            </li>
                                        </template>
                                    </ul>

                                    <ul class="col-md-2 col-sm-4 col-6">
                                        <span class="column-header"
                                            >Elemental Resist:</span
                                        >
                                        <template
                                            v-for="(resist,
                                            key,
                                            index) in elemental"
                                        >
                                            <li
                                                v-if="resist !== 0"
                                                :key="index"
                                            >
                                                {{ key | capitalize }}:
                                                {{ resist }}%
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="text-md-right mt-5">
                                <button
                                    class="btn btn-primary"
                                    @click.prevent="addUnit"
                                >
                                    Add Your Unit
                                </button>
                                <router-link
                                    to="/"
                                    tag="button"
                                    class="btn btn-link"
                                    >Cancel</router-link
                                >
                            </div>
                        </div>
                    </template>
                </template>
            </div>
        </form>
    </div>
</template>
<style scoped>
.error-msg {
    margin-bottom: 10px;
    font-size: 1.3em;
}

.incomplete {
    font-size: 1.3em;
}

ul {
    list-style: none;
}

.column-header {
    font-size: 1.1em;
    border-bottom: solid 1px black;
}

.find-header {
    font-size: 1.5em;
}

.panel-heading {
    font-size: 1.2em;
}
</style>

<script>
import Units from "../../data/units.json";
import Items from "../../data/items.json";
import axios from "axios";
import Swal from "sweetalert2";
import "vue-select/dist/vue-select.css";
import { eventBus } from "../../app";
import Loading from "../Spinner";
import Trials from "../../data/trials.json"

export default {
    data() {
        return {
            units: [],
            name: "",
            slot: "",
            buildType: "",
            elementWeapons: [],
            slotOptions: [
                "Favourite",
                "Event 1",
                "Event 2",
                "Nemesis 1",
                "Nemesis 2"
            ],
            buffed: false,
            buildURL: "", //test value = 22181910-0f01-11ea-b959-9b5568739fdf
            status: {
                poison: "",
                blind: "",
                sleep: "",
                paralyze: "",
                silence: "",
                confusion: "",
                disease: "",
                stone: "",
                death: "",
                charm: "",
                stop: ""
            },
            elemental: {
                fire: "",
                ice: "",
                lightning: "",
                water: "",
                wind: "",
                earth: "",
                light: "",
                dark: ""
            },
            physkillers: {
                aquatic: "",
                beast: "",
                bird: "",
                bug: "",
                demon: "",
                dragon: "",
                human: "",
                machine: "",
                plant: "",
                undead: "",
                stone: "",
                spirit: ""
            },
            magkillers: {
                aquatic: "",
                beast: "",
                bird: "",
                bug: "",
                demon: "",
                dragon: "",
                human: "",
                machine: "",
                plant: "",
                undead: "",
                stone: "",
                spirit: ""
            },
            hp: "",
            mp: "",
            atk: "",
            def: "",
            spr: "",
            mag: "",
            evade: "",
            lb_damage: "",
            max_rarity: 7,
            rarity: 5,
            errors: false,
            empty: false,
            loggedIn: true,
            unitFound: false,
            notFound: false,
            errorMsg: "",
            isLoading: false,
            trials: []
        };
    },
    components: {
        "app-loading": Loading
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

    },
    methods: {
        addUnit() {
            this.loggedIn = true;
            if (this.name && this.buildURL) {
                this.errors = false;
                this.empty = false;
                axios
                    .post("/api/units", {
                        rarity: this.rarity,
                        name: this.name,
                        atk: this.atk,
                        def: this.def,
                        mag: this.mag,
                        spr: this.spr,
                        hp: this.hp,
                        mp: this.mp,
                        pevade: this.evade,
                        status: this.status,
                        elemental: this.elemental,
                        magkillers: this.magkillers,
                        physkillers: this.physkillers,
                        build: this.buildURL,
                        max_rarity: this.max_rarity,
                        slot: this.slot,
                        element_weapon: this.elementWeapons.join(", "),
                        lb_damage: this.lb_damage,
                        built_for: this.buildType
                    })
                    .then(res => {
                        this.errors = false;
                        Swal.fire(
                            "Adding Unit",
                            "Unit added successfully!",
                            "success"
                        ).then(this.$router.push("/"));
                    })
                    .catch(err => {
                        switch (err.response.data) {
                            case 1:
                                this.errorMsg =
                                    "Unit quota of 5 reached. Please delete a unit and try again.";
                                break;
                            case 2:
                                this.errorMsg = "Please complete your profile.";
                                break;
                            default:
                                this.errorMsg =
                                    "Server Errror. Please try again later.";
                        }
                        this.errors = true;
                        this.loggedIn = false;
                    });
            } else {
                this.errors = true;
            }
        },
        getMaxRarity() {
            this.max_rarity = parseInt(this.name.rarity);
        },
        fillForm() {
            if (this.buildURL === "") {
                this.empty = true;
            } else {
                this.empty = false;
                this.isLoading = true;
                this.unitFound = false;
                this.notFound = false;
                this.buffed = false;
                axios
                    .get(
                        "https://firebasestorage.googleapis.com/v0/b/ffbeequip.appspot.com/o/PartyBuilds%2F" +
                            this.buildURL +
                            ".json?alt=media"
                    )
                    .then(res => {
                        let checkBuff = this.checkBuffs(
                            res.data.units[0].buffs
                        );
                        this.isLoading = false;
                        if (checkBuff) {
                            //b6091bd0-12f1-11ea-9f71-fbb311f0fb55 test value
                            this.buffed = true;
                        } else {
                            this.buffed = false;
                            this.unitFound = true;
                            this.notFound = false;
                            let unit = res.data.units[0].calculatedValues;
                            let key = res.data.units[0].id;
                            let findUnit = this.units.find(x => x.id === key);
                            this.elementWeapons = [];
                            this.slot = "";
                            // Get weapon elements
                            let weapons = res.data.units[0].items;
                            weapons.find(x => {
                                if (x.slot === 0 || x.slot === 1) {
                                    let temp = Items.find(i => i.id === x.id);
                                    if (temp.element) {
                                        this.elementWeapons.push(
                                            temp.element[0]
                                                .charAt(0)
                                                .toUpperCase() +
                                                temp.element[0].slice(1)
                                        );
                                    }
                                }
                            });

                            //unit info
                            this.rarity = res.data.units[0].rarity;
                            this.name = findUnit.name;

                            //base stats
                            this.atk = unit.atk.value;
                            this.mag = unit.mag.value;
                            this.def = unit.def.value;
                            this.spr = unit.spr.value;
                            this.hp = unit.hp.value;
                            this.mp = unit.mp.value;
                            this.evade = unit.physicalEvasion.value;
                            this.lb_damage = unit.lbDamage.value;

                            //elemental resists
                            this.elemental.fire = unit.elementResists.fire;
                            this.elemental.ice = unit.elementResists.ice;
                            this.elemental.lightning =
                                unit.elementResists.lightning;
                            this.elemental.wind = unit.elementResists.wind;
                            this.elemental.earth = unit.elementResists.earth;
                            this.elemental.water = unit.elementResists.water;
                            this.elemental.light = unit.elementResists.light;
                            this.elemental.dark = unit.elementResists.dark;

                            //ailment resists
                            this.status.poison = unit.ailmentResists.poison;
                            this.status.blind = unit.ailmentResists.blind;
                            this.status.sleep = unit.ailmentResists.sleep;
                            this.status.silence = unit.ailmentResists.silence;
                            this.status.paralyze =
                                unit.ailmentResists.paralysis;
                            this.status.confusion = unit.ailmentResists.confuse;
                            this.status.disease = unit.ailmentResists.disease;
                            this.status.stone =
                                unit.ailmentResists.petrification;
                            this.status.death = unit.ailmentResists.death;
                            this.status.charm = unit.ailmentResists.charm;
                            this.status.stop = unit.ailmentResists.stop;

                            //physical killlers
                            this.physkillers.aquatic =
                                unit.killers.aquatic.physical;
                            this.physkillers.beast =
                                unit.killers.beast.physical;
                            this.physkillers.bird = unit.killers.bird.physical;
                            this.physkillers.bug = unit.killers.bug.physical;
                            this.physkillers.demon =
                                unit.killers.demon.physical;
                            this.physkillers.dragon =
                                unit.killers.dragon.physical;
                            this.physkillers.human =
                                unit.killers.human.physical;
                            this.physkillers.machine =
                                unit.killers.machine.physical;
                            this.physkillers.plant =
                                unit.killers.plant.physical;
                            this.physkillers.undead =
                                unit.killers.undead.physical;
                            this.physkillers.stone =
                                unit.killers.stone.physical;
                            this.physkillers.spirit =
                                unit.killers.spirit.physical;

                            //magical killlers
                            this.magkillers.aquatic =
                                unit.killers.aquatic.magical;
                            this.magkillers.beast = unit.killers.beast.magical;
                            this.magkillers.bird = unit.killers.bird.magical;
                            this.magkillers.bug = unit.killers.bug.magical;
                            this.magkillers.demon = unit.killers.demon.magical;
                            this.magkillers.dragon =
                                unit.killers.dragon.magical;
                            this.magkillers.human = unit.killers.human.magical;
                            this.magkillers.machine =
                                unit.killers.machine.magical;
                            this.magkillers.plant = unit.killers.plant.magical;
                            this.magkillers.undead =
                                unit.killers.undead.magical;
                            this.magkillers.stone = unit.killers.stone.magical;
                            this.magkillers.spirit =
                                unit.killers.spirit.magical;
                        }
                    })
                    .catch(err => {
                        this.isLoading = false;
                        this.notFound = true;
                    });
            }
        },
        checkBuffs(buffs) {
            let buffed = false;
            Object.values(buffs).forEach(value => {
                if (typeof value === "object") {
                    Object.values(value).forEach(i => {
                        if (i !== 0) {
                            buffed = true;
                        }
                    });
                } else {
                    if (value !== 0) {
                        buffed = true;
                    }
                }
            });
            return buffed;
        }
    }
};
</script>
