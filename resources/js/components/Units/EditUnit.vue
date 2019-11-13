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
                    <div class="form-group">
                        <label for="name" class="my-3">Update Build</label>
                        <div class="col">
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
                                <a href="https://ffbeequip.com/builder.html"
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

<script>
import axios from "axios";
import Swal from "sweetalert2";
export default {
    props: ["unit"],
    data() {
        return {
            name: "",
            new_build: "",
            error: false,
            loading: false,
            notFound: false
        };
    },
    created() {
        $("#myModal").on("shown.bs.modal", function() {
            $("#myInput").trigger("focus");
        });
    },
    methods: {
        updateUnit(unit) {
            this.new_build.trim() === ""
                ? (this.new_build = unit.build)
                : this.new_build;

            if (this.new_build === "") {
                this.error = true;
            } else {
                this.error = false;
                this.notFound = false
                axios
                    .get(
                        "https://firebasestorage.googleapis.com/v0/b/ffbeequip.appspot.com/o/PartyBuilds%2F" +
                            this.new_build +
                            ".json?alt=media"
                    )
                    .then(res => {
                        let newUnit = res.data.units[0].calculatedValues;
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
                                max_rarity: this.max_rarity
                            })
                            .then(response => {
                                Swal.fire(
                                    "Updating Unit",
                                    "Unit updated successfully!",
                                    "success"
                                ).then((unit.build = this.new_build));
                            })
                            .catch(error => {
                                console.log(error.response);
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
