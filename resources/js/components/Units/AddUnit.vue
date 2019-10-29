<template>
  <div>
    <h1>Add Your Unit</h1>
    <p class="mb-4 incomplete">
      Make sure to <a href="/login"> Login </a> and complete Your Profile before adding a unit
    </p>
    <hr />
    <form>
      <div class="form-group">
        <div v-if="errors">
          <h3 v-if="empty" class="text-danger error-msg">Please fill out all fields</h3>
          <h3
            v-if="!loggedIn"
            class="text-danger error-msg"
          >Error adding unit. Please check to see if you are logged in and/or complete your profile.</h3>

          <h3 v-if="invalidField" class="text-danger error-msg">Stats must be numeric values!</h3>
        </div>
        <div class="form-row">
          <div class="form-group col-md-5">
            <label for="unitName">Unit Name</label>
            <app-v-select id="unitName" v-model="name" :options="units" label="name" index="id"></app-v-select>
          </div>
          <div class="col-sm-6 ml-md-5">
            <label for="input-type">Rarity</label>
            <div id="input-type" class="row">
              <div class="col-md-2">
                <label class="radio-inline">
                  <input v-model="rarity" name="rarity" value="5" type="radio" /> 5&#x2605;
                </label>
              </div>
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
            <div class="col-md-5 mr-2 col-sm-12">
              <input
                type="text"
                readonly
                class="form-control-plaintext ml-md-3"
                id="staticEmail"
                value="ffbeEquip.com/builder.html?server=GL#"
              />
            </div>
            <div class="col-md-6 col-sm-12">
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
        <div class="text-md-right mt-5">
          <button class="btn btn-primary" @click.prevent="addUnit">Add Your Unit</button>
          <router-link to="/" tag="button" class="btn btn-link">Cancel</router-link>
        </div>
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
</style>

<script>
import Units from "../../data/units.json";
import axios from "axios";
import Swal from "sweetalert2";
import "vue-select/dist/vue-select.css";
import { eventBus } from "../../app";

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
      rarity: 7,
      errors: false,
      empty: true,
      invalidField: false,
      loggedIn: true
    };
  },
  created() {
    for (let key in Units) {
      this.units.push({ name: Units[key].name, id: key });
    }
    this.units.sort((a, b) => (a.name > b.name ? 1 : -1));
  },
  methods: {
    addUnit() {
      this.empty = true;
      this.invalidField = false;
      this.loggedIn = true;
      if (
        this.name &&
        this.buildURL &&
        this.atk &&
        this.def &&
        this.mag &&
        this.spr
      ) {
        if (
          isNaN(this.atk) ||
          isNaN(this.def) ||
          isNaN(this.spr) ||
          isNaN(this.mag)
        ) {
          console.log("here");
          this.errors = true;
          this.empty = false;
          this.invalidField = true;
        } else {
          this.errors = false;
          this.empty = false;
          this.invalidField = false;
          axios
            .post("/api/units", {
              rarity: this.rarity,
              name: this.name.name,
              atk: this.atk,
              def: this.def,
              mag: this.mag,
              spr: this.spr,
              build: this.buildURL
            })
            .then(res => {
              console.log(res);
              if (res.status !== 500) {
                this.errors = false;
                Swal.fire(
                  "Adding Unit",
                  "Unit added successfully!",
                  "success"
                ).then(this.$router.push("/profile"));
              } else {
                this.errors = true;
                this.loggedIn = false;
              }
            })
            .catch(err => {
              console.log(err.response);
              this.errors = true;
              this.loggedIn = false;
            });
        }
      } else {
        this.errors = true;
      }
    }
  }
};
</script>
