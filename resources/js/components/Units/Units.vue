<template>
  <div>
    <h1 class="mb-4">Unit Listings</h1>
    <div class="col-md-8 my-5 mx-0 mx-auto">
      <input class="form-control" type="text" v-model="search" placeholder="Search Units..." />
    </div>
    <div class="d-md-flex justify-content-md-between mt-5 mb-4">
      <router-link class="btn btn-info mb-3" to="/unit/add" tag="button">Add Your Unit</router-link>
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
    >
      <template v-slot:cell(build)="data">
        <a target="_blank" :href="link + data.item.build">Build</a>
      </template>

      <template v-slot:cell(profile)="data">
        <p>{{data.item.profile.ign }} - {{data.item.profile.friendCode | friendCode}}</p>
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
export default {
  data() {
    return {
      perPage: 10,
      currentPage: 1,
      search: "",
      fields: [
        {
          key: "name",
          label: "Unit Name",
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
          key: "build",
          label: "Build Link",
          sortable: false
        },
        {
          key: "profile",
          label: "Profile",
          sortable: false
        }
      ],
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
        return unit.name.toLowerCase().match(this.search.toLowerCase());
      });
    },
    rows() {
      return this.filterUnits.length;
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
