<template>
  <div>
    <h1 class="mt-4">Add Your Unit</h1>
    <p class="mb-4 incomplete">
      Make sure to complete
      <router-link to="/profile" tag="a">Your Profile</router-link>before adding a unit
    </p>
    <hr />
    <form>
      <div class="form-group mb-5">
        <h3>Fill Form Using Build Link</h3>
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
              The Link can be found under 'Share this Build > FFBE Equip link (this unit only)' on
              <a
                href="https://ffbeequip.com/builder.html"
              >FFBE Equip</a>
            </small>
          </div>
        </div>
        <div class="form-group">
          <div class="text-md-right mt-5">
            <button class="btn btn-primary" @click.prevent="fillForm">Fill Form</button>
          </div>
        </div>
      </div>
      <hr />
      <div class="form-group">
        <h3 class="mb-3">Unit Info</h3>
        <hr />
        <div v-if="errors">
          <h3 v-if="empty" class="text-danger error-msg">Please fill out all fields</h3>
          <h3 v-if="!loggedIn" class="text-danger error-msg">Error adding unit. {{errorMsg}}</h3>
        </div>
        <div class="form-row">
          <div class="form-group col-md-5">
            <label for="unitName">Unit Name</label>
            <app-v-select
              id="unitName"
              v-model="name"
              :options="units"
              label="name"
              index="id"
              @input="getMaxRarity"
            ></app-v-select>
          </div>
          <div class="col-3 ml-md-5">
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
              <div v-if="max_rarity === 7" class="col-md-2">
                <label class="radio-inline">
                  <input v-model="rarity" name="rarity" value="7" type="radio" /> 7&#x2605;
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr />
      <div class="form-group">
        <h3>Unit Stats</h3>
        <div class="form-row">
          <div class="form-group col-md-2 col-3">
            <label for="health">HP</label>
            <input
              readonly
              v-model="hp"
              type="text"
              class="form-control"
              id="health"
              placeholder="Unit Health"
            />
          </div>
          <div class="form-group col-md-2 col-3">
            <label for="mana">MP</label>
            <input
              readonly
              v-model="mp"
              type="text"
              class="form-control"
              id="mana"
              placeholder="Unit Mana"
            />
          </div>
          <div class="form-group col-md-2 col-3">
            <label for="attack">ATK</label>
            <input
              readonly
              v-model="atk"
              type="text"
              class="form-control"
              id="attack"
              placeholder="Unit Attack"
            />
          </div>
          <div class="form-group col-md-2 col-3">
            <label for="defense">DEF</label>
            <input
              readonly
              v-model="def"
              type="text"
              class="form-control"
              id="defense"
              placeholder="Unit Defense"
            />
          </div>
          <div class="form-group col-md-2 col-3">
            <label for="magic">MAG</label>
            <input
              readonly
              v-model="mag"
              type="text"
              class="form-control"
              id="magic"
              placeholder="Unit Magic"
            />
          </div>
          <div class="form-group col-md-2 col-3">
            <label for="spirit">SPR</label>
            <input
              readonly
              v-model="spr"
              type="text"
              class="form-control"
              id="spirit"
              placeholder="Unit Spirit"
            />
          </div>
          <div class="form-group col-md-2 col-3">
            <label for="evade">P.Evade</label>
            <input
              readonly
              v-model="evade"
              type="text"
              class="form-control"
              id="evade"
              placeholder="Unit evade"
            />
          </div>
        </div>
      </div>
      <hr />
      <div class="form-group">
        <h3>Elemental Resist</h3>
        <div class="form-row">
          <div class="form-group col-md-2 col-3">
            <label for="fire">Fire</label>
            <input
              readonly
              v-model="elemental.fire"
              type="text"
              class="form-control"
              id="fire"
              placeholder="% Resist"
            />
          </div>
          <div class="form-group col-md-2 col-3">
            <label for="ice">Ice</label>
            <input
              readonly
              v-model="elemental.ice"
              type="text"
              class="form-control"
              id="ice"
              placeholder="% Resist"
            />
          </div>
          <div class="form-group col-md-2 col-3">
            <label for="lightning">Lightning</label>
            <input
              readonly
              v-model="elemental.lightning"
              type="text"
              class="form-control"
              id="lightning"
              placeholder="% Resist"
            />
          </div>
          <div class="form-group col-md-2 col-3">
            <label for="water">Water</label>
            <input
              readonly
              v-model="elemental.water"
              type="text"
              class="form-control"
              id="water"
              placeholder="% Resist"
            />
          </div>
          <div class="form-group col-md-2 col-3">
            <label for="wind">Wind</label>
            <input
              readonly
              v-model="elemental.wind"
              type="text"
              class="form-control"
              id="wind"
              placeholder="% Resist"
            />
          </div>
          <div class="form-group col-md-2 col-3">
            <label for="earth">Earth</label>
            <input
              readonly
              v-model="elemental.earth"
              type="text"
              class="form-control"
              id="earth"
              placeholder="% Resist"
            />
          </div>
          <div class="form-group col-md-2 col-3">
            <label for="light">Light</label>
            <input
              readonly
              v-model="elemental.light"
              type="text"
              class="form-control"
              id="light"
              placeholder="% Resist"
            />
          </div>
          <div class="form-group col-md-2 col-3">
            <label for="dark">Dark</label>
            <input
              readonly
              v-model="elemental.dark"
              type="text"
              class="form-control"
              id="dark"
              placeholder="% Resist"
            />
          </div>
        </div>
      </div>
      <div class="form-group">
        <h3>Status Resist</h3>
        <div class="form-row">
          <div class="form-group col-md-1 col-3 col-xs-4">
            <label for="status_poison">Poison</label>
            <input
              readonly
              v-model="status.poison"
              type="text"
              class="form-control"
              id="status_poison"
              placeholder="% Resist"
            />
          </div>
          <div class="form-group col-md-1 col-3 col-xs-4">
            <label for="status_blind">Blind</label>
            <input
              readonly
              v-model="status.blind"
              type="text"
              class="form-control"
              id="status_blind"
              placeholder="% Resist"
            />
          </div>
          <div class="form-group col-md-1 col-3 col-xs-4">
            <label for="status_sleep">Sleep</label>
            <input
              readonly
              v-model="status.sleep"
              type="text"
              class="form-control"
              id="status_sleep"
              placeholder="% Resist"
            />
          </div>
          <div class="form-group col-md-1 col-3 col-xs-4">
            <label for="status_silence">Silence</label>
            <input
              readonly
              v-model="status.silence"
              type="text"
              class="form-control"
              id="status_silence"
              placeholder="% Resist"
            />
          </div>
          <div class="form-group col-md-1 col-3 col-xs-4">
            <label for="status_paralyze">Paralyze</label>
            <input
              readonly
              v-model="status.paralyze"
              type="text"
              class="form-control"
              id="status_paralyze"
              placeholder="% Resist"
            />
          </div>
          <div class="form-group col-md-1 col-3 col-xs-4">
            <label for="status_confusion">Confusion</label>
            <input
              readonly
              v-model="status.confusion"
              type="text"
              class="form-control"
              id="status_confusion"
              placeholder="% Resist"
            />
          </div>
          <div class="form-group col-md-1 col-3 col-xs-4">
            <label for="status_disease">Disease</label>
            <input
              readonly
              v-model="status.disease"
              type="text"
              class="form-control"
              id="status_disease"
              placeholder="% Resist"
            />
          </div>
          <div class="form-group col-md-1 col-3 col-xs-4">
            <label for="status_stone">Stone</label>
            <input
              readonly
              v-model="status.stone"
              type="text"
              class="form-control"
              id="status_stone"
              placeholder="% Resist"
            />
          </div>
          <div class="form-group col-md-1 col-3 col-xs-4">
            <label for="status_death">Death</label>
            <input
              readonly
              v-model="status.death"
              type="text"
              class="form-control"
              id="status_death"
              placeholder="% Resist"
            />
          </div>
          <div class="form-group col-md-1 col-3 col-xs-4">
            <label for="status_charm">Charm</label>
            <input
              readonly
              v-model="status.charm"
              type="text"
              class="form-control"
              id="status_charm"
              placeholder="% Resist"
            />
          </div>
          <div class="form-group col-md-1 col-3 col-xs-4">
            <label for="status_stop">Stop</label>
            <input
              readonly
              v-model="status.stop"
              type="text"
              class="form-control"
              id="status_"
              placeholder="% Resist"
            />
          </div>
        </div>
      </div>
      <hr />
      <div class="form-group">
        <h3>Physical Killers</h3>
        <div class="form-row">
          <div class="form-group col-md-1 col-3">
            <label for="aquatic-killer">Aquatic</label>
            <input
              readonly
              v-model="physkillers.aquatic"
              type="text"
              class="form-control"
              id="aquatic-killer"
              placeholder="% Killer"
            />
          </div>
          <div class="form-group col-md-1 col-3">
            <label for="beast-killer">Beast</label>
            <input
              readonly
              v-model="physkillers.beast"
              type="text"
              class="form-control"
              id="beast-killer"
              placeholder="% Killer"
            />
          </div>
          <div class="form-group col-md-1 col-3">
            <label for="bird-killer">Bird</label>
            <input
              readonly
              v-model="physkillers.bird"
              type="text"
              class="form-control"
              id="bird-killer"
              placeholder="% Killer"
            />
          </div>
          <div class="form-group col-md-1 col-3">
            <label for="bug-killer">Bug</label>
            <input
              readonly
              v-model="physkillers.bug"
              type="text"
              class="form-control"
              id="bug-killer"
              placeholder="% Killer"
            />
          </div>
          <div class="form-group col-md-1 col-3">
            <label for="demon-killer">Demon</label>
            <input
              readonly
              v-model="physkillers.demon"
              type="text"
              class="form-control"
              id="demon-killer"
              placeholder="% Killer"
            />
          </div>
          <div class="form-group col-md-1 col-3">
            <label for="dragon-killer">Dragon</label>
            <input
              readonly
              v-model="physkillers.dragon"
              type="text"
              class="form-control"
              id="dragon-killer"
              placeholder="% Killer"
            />
          </div>
          <div class="form-group col-md-1 col-3">
            <label for="human-killer">Human</label>
            <input
              readonly
              v-model="physkillers.human"
              type="text"
              class="form-control"
              id="human-killer"
              placeholder="% Killer"
            />
          </div>
          <div class="form-group col-md-1 col-3">
            <label for="machine-killer">Machine</label>
            <input
              readonly
              v-model="physkillers.machine"
              type="text"
              class="form-control"
              id="machine-killer"
              placeholder="% Killer"
            />
          </div>
          <div class="form-group col-md-1 col-3">
            <label for="plant-killer">Plant</label>
            <input
              readonly
              v-model="physkillers.plant"
              type="text"
              class="form-control"
              id="plant-killer"
              placeholder="% Killer"
            />
          </div>
          <div class="form-group col-md-1 col-3">
            <label for="undead-killer">Undead</label>
            <input
              readonly
              v-model="physkillers.undead"
              type="text"
              class="form-control"
              id="undead-killer"
              placeholder="% Killer"
            />
          </div>
          <div class="form-group col-md-1 col-3">
            <label for="stone-killer">Stone</label>
            <input
              readonly
              v-model="physkillers.stone"
              type="text"
              class="form-control"
              id="stone-killer"
              placeholder="% Killer"
            />
          </div>
          <div class="form-group col-md-1 col-3">
            <label for="spirit-killer">Spirit</label>
            <input
              readonly
              v-model="physkillers.spirit"
              type="text"
              class="form-control"
              id="spirit-killer"
              placeholder="% Killer"
            />
          </div>
        </div>
      </div>
      <div class="form-group">
        <h3>Magic Killers</h3>
        <div class="form-row">
          <div class="form-group col-md-1 col-3">
            <label for="aquatic-mag-killer">Aquatic</label>
            <input
              readonly
              v-model="magkillers.aquatic"
              type="text"
              class="form-control"
              id="aquatic-mag-killer"
              placeholder="% Killer"
            />
          </div>
          <div class="form-group col-md-1 col-3">
            <label for="beast-mag-killer">Beast</label>
            <input
              readonly
              v-model="magkillers.beast"
              type="text"
              class="form-control"
              id="beast-mag-killer"
              placeholder="% Killer"
            />
          </div>
          <div class="form-group col-md-1 col-3">
            <label for="bird-mag-killer">Bird</label>
            <input
              readonly
              v-model="magkillers.bird"
              type="text"
              class="form-control"
              id="bird-mag-killer"
              placeholder="% Killer"
            />
          </div>
          <div class="form-group col-md-1 col-3">
            <label for="bug-mag-killer">Bug</label>
            <input
              readonly
              v-model="magkillers.bug"
              type="text"
              class="form-control"
              id="bug-mag-killer"
              placeholder="% Killer"
            />
          </div>
          <div class="form-group col-md-1 col-3">
            <label for="demon-mag-killer">Demon</label>
            <input
              readonly
              v-model="magkillers.demon"
              type="text"
              class="form-control"
              id="demon-mag-killer"
              placeholder="% Killer"
            />
          </div>
          <div class="form-group col-md-1 col-3">
            <label for="dragon-mag-killer">Dragon</label>
            <input
              readonly
              v-model="magkillers.dragon"
              type="text"
              class="form-control"
              id="dragon-mag-killer"
              placeholder="% Killer"
            />
          </div>
          <div class="form-group col-md-1 col-3">
            <label for="human-mag-killer">Human</label>
            <input
              readonly
              v-model="magkillers.human"
              type="text"
              class="form-control"
              id="human-mag-killer"
              placeholder="% Killer"
            />
          </div>
          <div class="form-group col-md-1 col-3">
            <label for="machine-mag-killer">Machine</label>
            <input
              readonly
              v-model="magkillers.machine"
              type="text"
              class="form-control"
              id="machine-mag-killer"
              placeholder="% Killer"
            />
          </div>
          <div class="form-group col-md-1 col-3">
            <label for="plant-mag-killer">Plant</label>
            <input
              readonly
              v-model="magkillers.plant"
              type="text"
              class="form-control"
              id="plant-mag-killer"
              placeholder="% Killer"
            />
          </div>
          <div class="form-group col-md-1 col-3">
            <label for="undead-mag-killer">Undead</label>
            <input
              readonly
              v-model="magkillers.undead"
              type="text"
              class="form-control"
              id="undead-mag-killer"
              placeholder="% Killer"
            />
          </div>
          <div class="form-group col-md-1 col-3">
            <label for="stone-mag-killer">Stone</label>
            <input
              readonly
              v-model="magkillers.stone"
              type="text"
              class="form-control"
              id="stone-mag-killer"
              placeholder="% Killer"
            />
          </div>
          <div class="form-group col-md-1 col-3">
            <label for="spirit-mag-killer">Spirit</label>
            <input
              readonly
              v-model="magkillers.spirit"
              type="text"
              class="form-control"
              id="spirit-mag-killer"
              placeholder="% Killer"
            />
          </div>
        </div>
      </div>
      <div class="form-group">
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
      buildURL: "", //test value = 2e4a2060-04d0-11ea-b49c-71a479b2e937
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
      max_rarity: 7,
      rarity: 5,
      errors: false,
      empty: true,
      loggedIn: true,
      errorMsg: ""
    };
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
  },
  methods: {
    addUnit() {
      this.empty = true;
      this.loggedIn = true;
      if (this.name && this.buildURL) {
        this.errors = false;
        this.empty = false;
        axios
          .post("/api/units", {
            rarity: this.rarity,
            name: this.name.name,
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
            max_rarity: this.max_rarity
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
                this.errorMsg = "Server Errror. Please try again later.";
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
      axios
        .get(
          "https://firebasestorage.googleapis.com/v0/b/ffbeequip.appspot.com/o/PartyBuilds%2F" +
            this.buildURL +
            ".json?alt=media"
        )
        .then(res => {
          let unit = res.data.units[0].calculatedValues;
          let key = res.data.units[0].id;
          let findUnit = this.units.find(x => x.id === key);

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

          //elemental resists
          this.elemental.fire = unit.elementResists.fire;
          this.elemental.ice = unit.elementResists.ice;
          this.elemental.lightning = unit.elementResists.lightning;
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
          this.status.paralyze = unit.ailmentResists.paralysis;
          this.status.confusion = unit.ailmentResists.confuse;
          this.status.disease = unit.ailmentResists.disease;
          this.status.stone = unit.ailmentResists.petrification;
          this.status.death = unit.ailmentResists.death;
          this.status.charm = unit.ailmentResists.charm;
          this.status.stop = unit.ailmentResists.stop;

          //physical killlers
          this.physkillers.aquatic = unit.killers.aquatic.physical;
          this.physkillers.beast = unit.killers.beast.physical;
          this.physkillers.bird = unit.killers.bird.physical;
          this.physkillers.bug = unit.killers.bug.physical;
          this.physkillers.demon = unit.killers.demon.physical;
          this.physkillers.dragon = unit.killers.dragon.physical;
          this.physkillers.human = unit.killers.human.physical;
          this.physkillers.machine = unit.killers.machine.physical;
          this.physkillers.plant = unit.killers.plant.physical;
          this.physkillers.undead = unit.killers.undead.physical;
          this.physkillers.stone = unit.killers.stone.physical;
          this.physkillers.spirit = unit.killers.spirit.physical;

          //magical killlers
          this.magkillers.aquatic = unit.killers.aquatic.magical;
          this.magkillers.beast = unit.killers.beast.magical;
          this.magkillers.bird = unit.killers.bird.magical;
          this.magkillers.bug = unit.killers.bug.magical;
          this.magkillers.demon = unit.killers.demon.magical;
          this.magkillers.dragon = unit.killers.dragon.magical;
          this.magkillers.human = unit.killers.human.magical;
          this.magkillers.machine = unit.killers.machine.magical;
          this.magkillers.plant = unit.killers.plant.magical;
          this.magkillers.undead = unit.killers.undead.magical;
          this.magkillers.stone = unit.killers.stone.magical;
          this.magkillers.spirit = unit.killers.spirit.magical;
        })
        .catch(err => {
          console.log(err);
        });
    }
  }
};
</script>
