<template>
    <div
        class="modal fade"
        :id="`exampleModal${unit.id}`"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5
                        class="modal-title"
                        :id="`#exampleModalLabel${unit.id}`"
                    >
                        {{ unit.name }}
                        <span v-if="error" class="text-danger error-msg ml-3"
                            >Please fill out all fields correctly</span
                        >

                        <span
                            v-if="notFound"
                            class="text-danger error-msg ml-3"
                        >
                            Cannot Find Unit! Re-enter build ID.
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
                    <div class="col">
                        <div class="form-group row">
                            <label class="col-md-2" for="slotNum"
                                >Slot #:</label
                            >
                            <select
                                :name="'slot' + unit.id"
                                @input="new_slot = $event.target.value"
                                class="form-control col-md-9"
                                id="slotNum"
                            >
                                <option
                                    v-for="(slotOption, index) in slotOptions"
                                    :key="'slot' + index"
                                    :value="slotOption"
                                    :selected="
                                        slotOption === unit.slot
                                            ? 'selected'
                                            : ''
                                    "
                                    >{{ slotOption }}</option
                                >
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col">
                            <label for="trial_name"
                                >Built For (optional):</label
                            >
                            <app-v-select
                                id="trial_name"
                                v-model="new_buildType"
                                :options="trials"
                            >
                            </app-v-select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col">
                            <label for="name" class="my-1">Update Build</label>
                            <input
                                type="text"
                                readonly
                                class="form-control-plaintext ml-3"
                                id="staticEmail"
                                value="ffbeEquip.com/builder.html?server=GL#"
                            />
                        </div>
                        <div class="col">
                            <input
                                :value="unit.build"
                                @input="new_build = $event.target.value"
                                type="text"
                                class="form-control"
                                id="name"
                                placeholder="63304e00-f44d-11e9-8f21-29aab363c1db"
                                aria-describedby="buildUrlBlock"
                            />
                            <small
                                id="buildUrlBlock"
                                class="form-text text-muted"
                            >
                                Ex. Link can be found under 'Share this Build >
                                FFBE Equip link (this link only)' on
                                <a
                                    target="_blank"
                                    href="https://ffbeequip.com/builder.html"
                                    >FFBE Equip</a
                                >
                            </small>
                        </div>
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
                        @click="updateUnit(unit)"
                    >
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.error-msg{
    font-size: 16px;
}
</style>

<script>
import axios from "axios";
import Swal from "sweetalert2";
import Items from "../../data/items.json";
import Trials from "../../data/trials.json";

export default {
    props: ["unit"],
    data() {
        return {
            name: "",
            new_build: "",
            new_slot: "",
            new_buildType: "",
            slotOptions: [
                "",
                "Favourite",
                "Event 1",
                "Event 2",
                "Nemesis 1",
                "Nemesis 2",
                "On Request"
            ],
            elementWeapons: [],
            error: false,
            loading: false,
            notFound: false,
            trials: []
        };
    },
    created() {
        $("#myModal").on("shown.bs.modal", function() {
            $("#myInput").trigger("focus");
        });

        for (let key in Trials) {
            Trials[key].trials.forEach(trial => {
                this.trials.push(trial);
            });
        }
    },
    methods: {
        setBuildType(value) {
            this.new_buildType = value;
        },
        updateUnit(unit) {
            this.new_build.trim() === ""
                ? (this.new_build = unit.build)
                : this.new_build;

            this.new_slot.trim() === ""
                ? (this.new_slot = unit.slot)
                : this.new_slot;

            if (this.new_build === "") {
                this.error = true;
            } else {
                this.error = false;
                this.notFound = false;
                axios
                    .get(
                        "https://firebasestorage.googleapis.com/v0/b/ffbeequip.appspot.com/o/PartyBuilds%2F" +
                            this.new_build +
                            ".json?alt=media"
                    )
                    .then(res => {
                        this.elementWeapons = [];
                        let newUnit = res.data.units[0].calculatedValues;
                        let weapons = res.data.units[0].items.slice(0, 2);

                        weapons.forEach(weapon => {
                            let temp = Items.find(i => i.id === weapon.id);
                            if (temp.element) {
                                this.elementWeapons.push(
                                    temp.element[0].charAt(0).toUpperCase() +
                                        temp.element[0].slice(1)
                                );
                            }
                        });

                        axios
                            .put("/api/units/" + unit.id, {
                                name: unit.name,
                                rarity: res.data.units[0].rarity,
                                atk: newUnit.atk.value,
                                def: newUnit.def.value,
                                mag: newUnit.mag.value,
                                spr: newUnit.spr.value,
                                hp: newUnit.hp.value,
                                mp: newUnit.mp.value,
                                pevade: newUnit.physicalEvasion.value,
                                lb_damage: newUnit.lbDamage.value,
                                status: newUnit.ailmentResists,
                                elemental: newUnit.elementResists,
                                magkillers: {
                                    aquatic: newUnit.killers.aquatic.magical,
                                    beast: newUnit.killers.beast.magical,
                                    bird: newUnit.killers.bird.magical,
                                    bug: newUnit.killers.bug.magical,
                                    demon: newUnit.killers.demon.magical,
                                    dragon: newUnit.killers.dragon.magical,
                                    human: newUnit.killers.human.magical,
                                    machine: newUnit.killers.machine.magical,
                                    plant: newUnit.killers.plant.magical,
                                    undead: newUnit.killers.undead.magical,
                                    stone: newUnit.killers.stone.magical,
                                    spirit: newUnit.killers.spirit.magical
                                },
                                physkillers: {
                                    aquatic: newUnit.killers.aquatic.physical,
                                    beast: newUnit.killers.beast.physical,
                                    bird: newUnit.killers.bird.physical,
                                    bug: newUnit.killers.bug.physical,
                                    demon: newUnit.killers.demon.physical,
                                    dragon: newUnit.killers.dragon.physical,
                                    human: newUnit.killers.human.physical,
                                    machine: newUnit.killers.machine.physical,
                                    plant: newUnit.killers.plant.physical,
                                    undead: newUnit.killers.undead.physical,
                                    stone: newUnit.killers.stone.physical,
                                    spirit: newUnit.killers.spirit.physical
                                },
                                build: this.new_build,
                                max_rarity: this.max_rarity,
                                element_weapon: this.elementWeapons.join(", "),
                                slot: this.new_slot,
                                built_for: this.new_buildType
                            })
                            .then(response => {
                                Swal.fire(
                                    "Updating Unit",
                                    "Unit updated successfully!",
                                    "success"
                                ).then(
                                    ((unit.build = this.new_build),
                                    (unit.built_for = this.new_buildType),
                                    (unit.slot = this.new_slot))
                                );
                            })
                            .catch(error => {
                                this.error = true;
                            });
                    })
                    .catch(err => {
                        this.notFound = true;
                    });
            }
        }
    }
};
</script>
