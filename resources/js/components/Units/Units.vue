<template>
  <div>
    <h1 class="mb-4">Unit Listings</h1>
    <div class="col-md-8 my-5 mx-0 mx-auto">
      <input class="form-control" type="text" v-model="search" placeholder="Search Units..." />
    </div>
    <div class="d-md-flex justify-content-md-between mt-5 mb-4">
      <a class="btn btn-info mb-3" href="https://ffbe-friends.herokuapp.com/unit/add" tag="button">Add Your Unit</a>
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
    >
      <template v-slot:empty="scope">
        <h4>{{scope.emptyText}}</h4>
      </template>

      <template v-slot:empty="scope">
        <h4>{{scope.emptyFilteredText}}</h4>
      </template>

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
import Swal from "sweetalert2";
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
        return unit.name.toLowerCase().match(this.search.toLowerCase());
      });
    },
    rows() {
      return this.filterUnits.length;
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


</style>
