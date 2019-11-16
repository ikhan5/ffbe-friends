<template>
    <div>
        <h1 class="my-4">User Profile</h1>
        <div v-if="usernameError" class="text-center text-danger">
            <p>Usename Required AND Must not have no spaces.</p>
        </div>
        <div v-if="friendCodeError" class="text-center text-danger">
            <p>Friend Code Required AND Must be 9 Numbers Long.</p>
        </div>
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
                    placeholder="In Game Name, Enter without spaces"
                    :class="{ errors: usernameError }"
                    maxlength="20"
                />
            </div>
            <div class="form-group form-inline">
                <label class="col-md-2 mr-2" for="FriendCode"
                    >Friend Code</label
                >
                <input
                    v-model="friendCode"
                    type="text"
                    class="form-control col-md-8"
                    placeholder="Ex. 123456789, Enter without commas, spaces or dashes"
                    :class="{ errors: friendCodeError }"
                />
            </div>
            <div class="form-group form-inline">
                <label class="col-md-2 mr-2" for="FriendCode">Reddit: u/</label>
                <input
                    v-model="reddit"
                    type="text"
                    class="form-control col-md-8"
                    placeholder="Just enter the username, no need for the u/"
                    :class="{ errors: friendCodeError }"
                />
            </div>
            <div class="form-group form-inline">
                <label class="col-md-2 mr-2" for="FriendCode"
                    >Discord Tag:</label
                >
                <input
                    v-model="discord"
                    type="text"
                    class="form-control col-md-8"
                    placeholder="Enter a DiscordTag#00000"
                    :class="{ errors: friendCodeError }"
                />
            </div>
            <div class="text-right col-md-12 mt-5">
                <button
                    v-if="firstTime"
                    class="btn btn-primary"
                    @click.prevent="addProfile"
                >
                    Save User Changes
                </button>
                <button
                    v-else
                    class="btn btn-primary"
                    @click.prevent="editProfile"
                >
                    Update User Info
                </button>
            </div>
        </form>
        <hr />
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a
                    class="nav-link active"
                    id="units-tab"
                    data-toggle="tab"
                    href="#units"
                    role="tab"
                    aria-controls="units"
                    aria-selected="true"
                    >Added Units</a
                >
            </li>
            <li class="nav-item">
                <a
                    class="nav-link"
                    id="unitRequests-tab"
                    data-toggle="tab"
                    href="#unitRequests"
                    role="tab"
                    aria-controls="unitRequests"
                    aria-selected="true"
                    >Unit Requests</a
                >
            </li>
            <!-- <li class="nav-item">
                <a
                    class="nav-link"
                    id="sentRequests-tab"
                    data-toggle="tab"
                    href="#sentRequests"
                    role="tab"
                    aria-controls="sentRequests"
                    aria-selected="true"
                    >Sent Requests</a
                >
            </li>
            <li class="nav-item">
                <a
                    class="nav-link"
                    id="receivedRequests-tab"
                    data-toggle="tab"
                    href="#receivedRequests"
                    role="tab"
                    aria-controls="receivedRequests"
                    aria-selected="true"
                    >Received Requests</a
                >
            </li> -->
        </ul>
        <div class="tab-content" id="myTabContent">
            <app-added-units :firstTime="firstTime"></app-added-units>
            <!-- <app-sent-requests
                :isLoading="notifLoading"
                :notifications="notifications"
            ></app-sent-requests>
            <app-received-requests
                :isLoading="notifLoading"
                :notifications="notifications"
            ></app-received-requests> -->
            <app-active-requests
                :isLoading="requestsLoading"
                :unitRequests="unitRequests"
            >
            </app-active-requests>
        </div>
    </div>
</template>

<style scoped>
.errors {
    border: solid 1px red;
}
</style>

<script>
import AddedUnits from "./AddedUnits";
import sentRequests from "../Requests/SentRequests";
import receivedRequests from "../Requests/ReceivedRequests";
import activeRequests from "../Requests/Unit/OpenRequests";
import axios from "axios";
import Swal from "sweetalert2";

import { eventBus } from "../../app";

export default {
    data() {
        return {
            username: "",
            friendCode: "",
            firstTime: true,
            profileId: "",
            reddit: "",
            discord: "",
            userUnits: [],
            profileComplete: false,
            loading: true,
            usernameError: false,
            friendCodeError: false,
            notifications: [],
            notifLoading: true,
            unitRequests: [],
            requestsLoading: true
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
                    this.reddit = res.data[0].reddit;
                    this.discord = res.data[0].discord;
                    this.firstTime = false;
                    this.profileComplete = true;
                    eventBus.$emit("profileIdUpdated", this.profileId);
                }
                this.loading = false;
            })
            .catch(err => {
                Swal.fire(
                    "Error, Kupo!",
                    "There was an error whilst loading your profile, please try again later",
                    "error"
                );
            });

        this.reloadNotifications();
        this.reloadRequests();
    },
    components: {
        "app-added-units": AddedUnits,
        "app-sent-requests": sentRequests,
        "app-received-requests": receivedRequests,
        "app-active-requests": activeRequests
    },
    methods: {
        reloadNotifications() {
            axios
                .get("/api/notifications")
                .then(res => {
                    this.notifications = res.data;
                    this.notifLoading = false;
                })
                .catch(err => {
                    Swal.fire(
                        "Error, Kupo!",
                        "There was an error whilst loading the requests, please try again later",
                        "error"
                    );
                });
        },
        reloadRequests() {
            axios
                .get("./api/getRequests")
                .then(res => {
                    this.unitRequests = res.data;
                    this.requestsLoading = false;
                })
                .catch(err => {
                    Swal.fire(
                        "Error, Kupo!",
                        "There was an error whilst loading the requests, please try again later",
                        "error"
                    );
                });
        },
        addProfile() {
            this.validateFriendCode(this.friendCode);
            this.validate(this.username);
            if (!this.friendCodeError && !this.usernameError) {
                axios
                    .post("/api/profile", {
                        friendCode: this.friendCode.trim(),
                        ign: this.username.trim(),
                        discord: this.discord.trim(),
                        reddit: this.reddit.trim()
                    })
                    .then(res => {
                        Swal.fire(
                            "Adding User Details",
                            "Details added successfully!",
                            "success"
                        );
                    })
                    .catch(err => {
                        Swal.fire(
                            "Error, Kupo!",
                            "There was an error whilst adding your profile, please try again later",
                            "error"
                        );
                    });
            }
        },
        editProfile() {
            this.validateFriendCode(this.friendCode);
            this.validate(this.username);
            if (!this.friendCodeError && !this.usernameError) {
                axios
                    .put("/api/profile/" + this.profileId, {
                        friendCode: this.friendCode.trim(),
                        ign: this.username.trim(),
                        discord: this.discord.trim(),
                        reddit: this.reddit.trim()
                    })
                    .then(res => {
                        Swal.fire(
                            "Updating User Details",
                            "Details updated successfully!",
                            "success"
                        );
                    })
                    .catch(err => {
                        Swal.fire(
                            "Error, Kupo!",
                            "There was an error whilst updating your profile, please try again later",
                            "error"
                        );
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
            if (
                username.trim() === "" ||
                username === undefined ||
                /\s/g.test(username)
            ) {
                this.usernameError = true;
            } else {
                this.usernameError = false;
            }
        }
    }
};
</script>
