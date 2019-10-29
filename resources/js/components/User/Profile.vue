<template>
  <div>
    <h1 class="mb-4">User Profile</h1>
    <div v-if="loading" class="text-center">
      <app-spinner></app-spinner>
    </div>
    <form v-else class="pb-2">
      <div class="form-group form-inline">
        <label class="col-md-2 mr-2" for="IGN">Username</label>
        <input
          v-model="username"
          type="text"
          class="form-control col-md-8"
          placeholder="In Game Name"
        />
      </div>
      <div class="form-group form-inline">
        <label class="col-md-2 mr-2" for="FriendCode">Friend Code</label>
        <input
          v-model="friendCode"
          type="text"
          class="form-control col-md-8"
          placeholder="123456789"
        />
      </div>
      <div class="text-right col-md-12 mt-5">
        <button
          v-if="firstTime"
          class="btn btn-primary"
          @click.prevent="addProfile"
        >Save User Changes</button>
        <button v-else class="btn btn-primary" @click.prevent="editProfile">Update User Info</button>
      </div>
    </form>
    <hr />
    <app-added-units></app-added-units>
  </div>
</template>

<script>
import AddedUnits from "./AddedUnits";
import axios from "axios";
import Swal from "sweetalert2";

import { eventBus } from "../../app";
import { mapActions } from "vuex";

export default {
  data() {
    return {
      username: "",
      friendCode: "",
      firstTime: true,
      profileId: "",
      userUnits: [],
      profileComplete: false,
      loading: true
    };
  },
  beforeCreate() {
    this.loading = true;
  },
  created() {
    axios
      .get("./api/profile")
      .then(res => {
        if (res.data.length === 0) {
          this.profileComplete = false;
        } else {
          this.profileId = res.data[0].id;
          this.username = res.data[0].ign;
          this.friendCode = res.data[0].friendCode;
          this.firstTime = false;
          this.profileComplete = true;
          eventBus.$emit("profileIdUpdated", this.profileId);
        }
        this.loading = false;
      })
      .catch(err => {
        console.log(err);
      });
  },
  components: {
    "app-added-units": AddedUnits
  },
  methods: {
    addProfile() {
      axios
        .post("/api/profile", {
          friendCode: this.friendCode,
          ign: this.username
        })
        .then(res => {
          console.log(res);
          Swal.fire(
            "Adding User Details",
            "Details added successfully!",
            "success"
          );
        })
        .catch(err => {
          console.log(err.response);
        });
    },
    editProfile() {
      axios
        .put("/api/profile/" + this.profileId, {
          friendCode: this.friendCode,
          ign: this.username
        })
        .then(res => {
          console.log(res);
          Swal.fire(
            "Updating User Details",
            "Details updated successfully!",
            "success"
          );
        })
        .catch(err => {
          console.log(err.response);
        });
    }
  }
};
</script>