<template>
  <div
    class="tab-pane fade show active mt-2"
    id="units"
    role="tabpanel"
    aria-labelledby="units-tab"
  >
    <table class="table table-responsive-md">
      <thead class="thead-light">
        <tr>
          <th scope="col" v-for="(column, index) in columns" :key="index">{{column}}</th>
        </tr>
      </thead>
      <td v-if="isLoading && !firstTime" class="text-center" colspan="7">
        <app-spinner></app-spinner>
      </td>
      <td v-else-if="units.length <= 0 || firstTime" class="text-center" colspan="7">
        No Units To Display. Complete your profile and
        <router-link to="/unit/add" tag="a">Add a unit here</router-link>.
      </td>
      <tbody v-else>
        <tr v-for="unit in units" :key="unit.id">
          <th scope="row">{{unit.name}} {{unit.rarity}}&#x2605;</th>
          <td>
            <a target="_blank" :href="link + unit.build">{{unit.build}}</a>
          </td>
          <td>
            <div class="row">
              <button
                class="no-style text-warning"
                data-toggle="modal"
                :data-target="`#exampleModal${unit.id}`"
              >
                <i class="far fa-edit"></i>
              </button>
              <app-edit-unit :unit="unit"></app-edit-unit>
              <button class="no-style text-danger" @click="deleteUnit(unit.id)">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <p>Note: Users are allowed up to 5 units.</p>
  </div>
</template>
<style scoped>
.no-style {
  background-color: white;
  border: solid 1px transparent;
  font-size: 1.1em;
}

.error-msg {
  margin-bottom: 10px;
  font-size: 1em;
}
</style>

<script>
import Swal from "sweetalert2";
import axios from "axios";
import EditUnit from "../Units/EditUnit";
import { eventBus } from "../../app";

export default {
  props: ["firstTime"],
  data() {
    return {
      columns: ["Name", "Build ID", "Actions"],
      link: "https://ffbeEquip.com/builder.html?server=GL#",
      units: [],
      isLoading: true,
      id: 0,
      isError: false
    };
  },
  created() {
    this.isLoading = true;
    eventBus.$on("profileIdUpdated", id => {
      this.id = id;
      this.getAllUnits(id);
    });
  },
  components: {
    "app-edit-unit": EditUnit
  },
  methods: {
    getAllUnits(id) {
      axios
        .get("./api/units/" + id)
        .then(res => {
          this.isLoading = false;
          this.units = res.data;
          eventBus.$emit("unitToEdit", this.units);
        })
        .catch(err => {
          Swal.fire(
            "Error, Kupo!",
            "There was an error whilst loading your units, please try again later",
            "error"
          );
        });
    },
    deleteUnit(unitID) {
      Swal.fire({
        title: "Deleting Unit",
        text: "Are you sure you want to delete this unit?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        if (result.value) {
          axios
            .delete("./api/units/" + unitID)
            .then(response => {
              Swal.fire("Deleted!", "Your unit has been deleted.", "success");
              this.getAllUnits(this.id);
            })
            .catch(error => {
              Swal.fire(
                "Error, Kupo!",
                "There was an error whilst deleting your unit, please try again later",
                "error"
              );
            });
        }
      });
    }
  }
};
</script>