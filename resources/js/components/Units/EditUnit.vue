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
          <h5 class="modal-title" :id="`#exampleModalLabel${unit.id}`">
            {{unit.name}}
            <span
              v-if="error"
              class="text-danger error-msg ml-3"
            >Please fill out all fields</span>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div class="form-row mb-3">
              <label class="col-md-12" for="input-type">Rarity</label>
              <div class="col-md-4">
                <input
                  type="radio"
                  id="five"
                  name="rarity"
                  :value="5"
                  @input="new_rarity = $event.target.value"
                />
                <label for="five">5&#x2605;</label>
              </div>
              <div class="col-md-4">
                <input
                  type="radio"
                  id="six"
                  name="rarity"
                  :value="6"
                  @input="new_rarity = $event.target.value"
                />
                <label for="six">6&#x2605;</label>
              </div>
              <div class="col-md-4">
                <input
                  type="radio"
                  id="seven"
                  name="rarity"
                  :value="7"
                  @input="new_rarity = $event.target.value"
                />
                <label for="seven">7&#x2605;</label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="attack">ATK</label>
                <input
                  :value="unit.atk"
                  @input="new_atk = $event.target.value"
                  type="text"
                  class="form-control"
                  id="attack"
                  placeholder="100"
                />
              </div>
              <div class="form-group col-md-3">
                <label for="defense">DEF</label>
                <input
                  :value="unit.def"
                  @input="new_def = $event.target.value"
                  type="text"
                  class="form-control"
                  id="defense"
                  placeholder="100"
                />
              </div>
              <div class="form-group col-md-3">
                <label for="magic">MAG</label>
                <input
                  :value="unit.mag"
                  @input="new_def = $event.target.value"
                  type="text"
                  class="form-control"
                  id="magic"
                  placeholder="100"
                />
              </div>
              <div class="form-group col-md-3">
                <label for="spirit">SPR</label>
                <input
                  :value="unit.spr"
                  @input="new_spr = $event.target.value"
                  type="text"
                  class="form-control"
                  id="spirit"
                  placeholder="100"
                />
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="name" class="my-3">Build URL</label>
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
                @input="new_build = $event.target.value "
                type="text"
                class="form-control"
                id="name"
                placeholder="63304e00-f44d-11e9-8f21-29aab363c1db"
                aria-describedby="buildUrlBlock"
              />
              <small id="buildUrlBlock" class="form-text text-muted">
                Ex. Link can be found under 'Share this Build > FFBE Equip link (this link only)' on
                <a
                  href="https://ffbeequip.com/builder.html"
                >FFBE Equip</a>
              </small>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" @click="updateUnit(unit)">Save changes</button>
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
      new_atk: "",
      new_def: "",
      new_spr: "",
      new_mag: "",
      new_rarity: "",
      error: false,
      loading: false
    };
  },
  created() {
    $("#myModal").on("shown.bs.modal", function() {
      $("#myInput").trigger("focus");
    });
  },
  methods: {
    updateUnit(unit) {
      this.new_atk.trim() === "" ? (this.new_atk = unit.atk) : this.new_atk;
      this.new_mag.trim() === "" ? (this.new_mag = unit.mag) : this.new_mag;
      this.new_def.trim() === "" ? (this.new_def = unit.def) : this.new_def;
      this.new_spr.trim() === "" ? (this.new_spr = unit.spr) : this.new_spr;
      this.new_build.trim() === ""
        ? (this.new_build = unit.build)
        : this.new_build;

      axios
        .put("/api/units/" + unit.id, {
          name: unit.name,
          atk: this.new_atk,
          def: this.new_def,
          mag: this.new_mag,
          spr: this.new_spr,
          build: this.new_build,
          rarity: this.new_rarity
        })
        .then(response => {
          Swal.fire(
            "Updating Unit",
            "Unit updated successfully!",
            "success"
          ).then(
            (unit.atk = this.new_atk),
            (unit.def = this.new_def),
            (unit.mag = this.new_mag),
            (unit.spr = this.new_spr),
            (unit.rarity = this.new_rarity),
            (unit.build = this.new_build)
          );
          console.log(response);
        })
        .catch(error => {
          this.error = true;
          console.log(error.response);
        });
    }
  }
};
</script>