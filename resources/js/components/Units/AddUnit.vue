<template>
  <form>
    <h1 class="mb-4">Add Your Unit</h1>
    <hr />
    <div class="form-group">
      <h3 v-if="errors" class="text-danger error-msg">Please fill out all fields</h3>
      <div class="form-row">
        <div class="form-group col-md-5">
          <label for="unitName">Unit Name</label>
          <select id="unitName" class="form-control" v-model="name">
            <option v-for="(unit,index) in units" :key="index">{{unit}}</option>
          </select>
        </div>
        <div class="col-sm-6 ml-5">
          <label for="input-type">Rarity</label>
          <div id="input-type" class="row">
            <div class="col-md-2">
              <label class="radio-inline">
                <input v-model="rarity" name="rarity" value="6" type="radio" /> 6&#x2605;
              </label>
            </div>
            <div class="col-md-2">
              <label class="radio-inline">
                <input v-model="rarity" name="rarity" value="7" type="radio" /> 7&#x2605;
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="attack">ATK</label>
          <input v-model="atk" type="text" class="form-control" id="attack" placeholder="100" />
        </div>
        <div class="form-group col-md-3">
          <label for="defense">DEF</label>
          <input v-model="def" type="text" class="form-control" id="defense" placeholder="100" />
        </div>
        <div class="form-group col-md-3">
          <label for="magic">MAG</label>
          <input v-model="mag" type="text" class="form-control" id="magic" placeholder="100" />
        </div>
        <div class="form-group col-md-3">
          <label for="spirit">SPR</label>
          <input v-model="spr" type="text" class="form-control" id="spirit" placeholder="100" />
        </div>
      </div>
      <div class="form-group">
        <label for="name" class="my-3">Build URL</label>
        <div class="form-row">
          <div class="col-md-4">
            <input
              type="text"
              readonly
              class="form-control-plaintext ml-3"
              id="staticEmail"
              value="ffbeEquip.com/builder.html?server=GL#"
            />
          </div>
          <div class="col-md-7">
            <input
              v-model="buildURL"
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
      <div class="text-right mt-5">
        <button class="btn btn-primary" @click.prevent="addUnit">Add Your Unit</button>
        <router-link to="/" tag="button" class="btn btn-link">Cancel</router-link>
      </div>
    </div>
  </form>
</template>
<style scoped>
.error-msg{
  margin-bottom: 10px;
  font-size: 1.3em;
}
</style>

<script>
import Units from "../../data/releasedUnits.json";
import axios from "axios";
export default {
  data() {
    return {
      units: [],
      name: "",
      buildURL: "",
      atk: "",
      def: "",
      spr: "",
      mag: "",
      rarity: 6,
      errors: false
    };
  },

  mounted() {
    for (let key in Units) {
      this.units.push(Units[key].name);
    }
    this.units.sort();
  },
  methods: {
    addUnit() {
      if (
        this.name &&
        this.buildURL &&
        this.atk &&
        this.def &&
        this.mag &&
        this.spr
      ) {
        axios
          .post("/api/units", {
            rarity: this.rarity,
            name: this.name,
            atk: this.atk,
            def: this.def,
            mag: this.mag,
            spr: this.spr,
            build: this.buildURL
          })
          .then(res => {
            console.log(res);
            this.errors=false;
          })
          .catch(err => {
            console.log(err.response);
          });
      } else {
        this.errors = true;
      }
    }
  }
};
</script>
