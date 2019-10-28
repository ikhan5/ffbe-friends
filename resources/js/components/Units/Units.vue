<template>
  <div>
    <h1 class="mb-4">Unit Listings</h1>
    <div class="col-md-8 my-4 mx-0 mx-auto">
      <input class="form-control" type="text" v-model="search" placeholder="Search Units..." />
    </div>
    <div class="float-right">
      <router-link class="btn btn-info mb-3" to="/unit/add" tag="button">Add Your Unit</router-link>
    </div>
    <table class="table table-responsive-md table-hover">
      <thead class="thead-light">
        <tr>
          <th scope="col" v-for="(column, index) in columns" :key="index">{{column}}</th>
        </tr>
      </thead>
      <td v-if="isLoading" class="text-center" colspan="7">
        <app-spinner></app-spinner>
      </td>
        <transition-group name="fade" tag="tbody" v-else>
          <tr v-for="unit in filterUnits" :key="unit.id">
            <th scope="row">{{unit.name}} {{unit.rarity}}&#x2605;</th>
            <td>{{unit.atk}}</td>
            <td>{{unit.mag}}</td>
            <td>{{unit.def}}</td>
            <td>{{unit.spr}}</td>
            <td>
              <a target="_blank" :href="link + unit.build">Build</a>
            </td>
            <td>{{unit.profile.ign}} - {{unit.profile.friendCode | friend-code}}</td>
          </tr>
        </transition-group>
    </table>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      search: "",
      columns: [
        "Unit Name",
        "ATK",
        "MAG",
        "DEF",
        "SPR",
        "Build Link",
        "Friend Info"
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
        console.log(err.response);
      });
  },
  computed: {
    filterUnits() {
      return this.units.filter(unit => {
        return (unit.name).toLowerCase().match(this.search.toLowerCase());
      });
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
div {
  margin-top: 10px;
}

h1 {
  margin-bottom: 30px;
}
</style>
