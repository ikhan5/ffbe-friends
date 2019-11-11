<template>
  <div>
    <h1 class="mb-4 mt-3">Unit Listings</h1>
    <div class="col-md-8 col-sm-12 my-5 mx-0 mx-auto">
      <input class="form-control" type="text" v-model="search" placeholder="Search Units..." />
    </div>
    <div class="d-md-flex float-right mb-4">
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
      <template v-slot:cell(name)="data">
        <p>{{data.item.name}} {{data.item.rarity}}&#x2605;</p>
      </template>

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

      <template v-slot:cell(request)="data">
        <button
          v-if="data.item.my_unit === 3"
          class="btn btn-link ml-5"
          @click="addNotify(data.item)"
        >
          <i class="fas fa-plus-circle"></i>
        </button>
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
          sortable: true
        },
        {
          key: "request",
          label: "Send Add Notification",
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
  },
  methods: {
    addNotify(unit) {
      let id = parseInt(unit.user_id);
      axios
        .post("/api/notifications", {
          receiving_id: id,
        })
        .then(res => {
          Swal.fire(
            "Sending Add Notification",
            "Notification sent successfully!",
            "success"
          );
          console.log(res.data);
        })
        .catch(err => {
          Swal.fire(
            "Error, Kupo!",
            "There was an error whilst sending the notification, please try again later",
            "error"
          );
        });
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
