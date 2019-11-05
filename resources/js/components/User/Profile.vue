<template>
  <div>
    <h1 class="mb-4">User Profile</h1>
    <div v-if="usernameError" class="text-center text-danger">
      <p>Usename Required AND Must not have no spaces.</p>
    </div>
    <div v-if="friendCodeError" class="text-center text-danger">
      <p>Friend Code Required AND Must be 9 Numbers Long.</p>
    </div>
    <div v-if="loading" class="text-center">
      <app-spinner></app-spinner>
    </div>
    <div v-else-if="SERVER_ERROR" class="text-center text-danger">
      <p>Error Loading Profile! Try Again Later</p>
    </div>
    <form v-if="!loading" class="pb-2">
      <div class="form-group form-inline">
        <label class="col-md-2 mr-2" for="IGN">Username</label>
        <input
          v-model="username"
          type="text"
          class="form-control col-md-8"
          placeholder="In Game Name"
          :class="{errors: usernameError}"
        />
      </div>
      <div class="form-group form-inline">
        <label class="col-md-2 mr-2" for="FriendCode">Friend Code</label>
        <input
          v-model="friendCode"
          type="text"
          class="form-control col-md-8"
          placeholder="123456789"
          :class="{errors: friendCodeError}"
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
    <app-added-units :firstTime="firstTime"></app-added-units>
  </div>
</template>

<style scoped>
.errors {
  border: solid 1px red;
}
</style>

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
      loading: true,
      usernameError: false,
      friendCodeError: false,
      SERVER_ERROR: false
    };
  },
  beforeCreate() {
    this.loading = true;
  },
  created() {
    axios
      .get("./api/profile")
      .then(res => {
        this.SERVER_ERROR = false;
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
        this.SERVER_ERROR = true;
      });
  },
  components: {
    "app-added-units": AddedUnits
  },
  methods: {
    addProfile() {
      validateFriendCode(this.friendCode);
      validate(this.username);
      if (!this.friendCodeError && !this.usernameError) {
        axios
          .post("/api/profile", {
            friendCode: this.friendCode,
            ign: this.username
          })
          .then(res => {
            Swal.fire(
              "Adding User Details",
              "Details added successfully!",
              "success"
            );
          })
          .catch(err => {
            console.log(err.response);
          });
      }
    },
    editProfile() {
      this.validateFriendCode(this.friendCode);
      this.validate(this.username);
      if (!this.friendCodeError && !this.usernameError) {
        axios
          .put("/api/profile/" + this.profileId, {
            friendCode: this.friendCode,
            ign: this.username
          })
          .then(res => {
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
    },
    validateFriendCode(friendCode) {
      if (
        this.friendCode.trim() === "" ||
        this.friendCode.trim() === undefined ||
        this.friendCode.trim().length !== 9 ||
        isNaN(this.friendCode)
      ) {
        this.friendCodeError = true;
      } else {
        this.friendCodeError = false;
      }
    },
    validate(username) {
      if (username.trim() === "" || username === undefined|| /\s/g.test(username)) {
        this.usernameError = true;
      } else {
        this.usernameError = false;
      }
    }
  }
};
</script>