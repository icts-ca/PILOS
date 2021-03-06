<template>
  <div>
    <b-form  @submit.stop.prevent :novalidate="true">
      <b-overlay :show="saving" >
      <div class="row" v-on:keyup.enter="save" @change="save">
        <!-- General settings tab -->
        <div class="col-lg-3 col-sm-12">
          <h5>{{ $t('rooms.settings.general.title') }}</h5>
          <b-form-group :state="fieldState('roomType')" :invalid-feedback="fieldError('roomType')" :label="$t('rooms.settings.general.type')">
            <b-input-group>
            <b-form-select :state="fieldState('roomType')" v-model.number="settings.roomType" :options="roomTypeSelect"></b-form-select>
            </b-input-group>
          </b-form-group>
          <!-- Room name -->
          <b-form-group :state="fieldState('name')" :invalid-feedback="fieldError('name')" :label="$t('rooms.settings.general.roomName')">
            <b-input-group>
              <b-form-input   :state="fieldState('name')" v-model="settings.name"></b-form-input>
            </b-input-group>
          </b-form-group>
          <!-- Welcome message -->
          <b-form-group :state="fieldState('welcome')" :invalid-feedback="fieldError('welcome')" :label="$t('rooms.settings.general.welcomeMessage')">
            <b-input-group >
              <b-form-textarea
                id="welcome"
                :placeholder="$t('rooms.settings.nonePlaceholder')"
                rows="3"
                :state="fieldState('welcome')"
                v-model="settings.welcome"
              ></b-form-textarea>
            </b-input-group>
            <small class="text-muted">
              {{$t('rooms.settings.general.chars', {chars: charactersLeftWelcomeMessage})}}</small>
          </b-form-group>

          <!-- Max duration -->
          <b-form-group :state="fieldState('duration')" :invalid-feedback="fieldError('duration')" :label="$t('rooms.settings.general.maxDuration')">
            <b-input-group>
              <b-form-input
                min="1"
                :placeholder="$t('rooms.settings.nonePlaceholder')"
                type="number"
                v-model.number="settings.duration"
                :state="fieldState('duration')"
              ></b-form-input>
              <b-input-group-append>
                <b-input-group-text>{{$t('rooms.settings.general.minutes')}}</b-input-group-text>
                <!-- Reset the duration -->
                <b-button
                  @click="clearDuration"
                  variant="outline-secondary"
                ><i class="fas fa-trash"></i
                ></b-button>
              </b-input-group-append>
            </b-input-group>
          </b-form-group>
        </div>

        <!-- Security settings tab -->
        <div class="col-lg-3 col-sm-12">
          <h5>{{ $t('rooms.settings.security.title') }}</h5>
          <!-- Access code -->
          <b-form-group :state="fieldState('accessCode')" :invalid-feedback="fieldError('accessCode')" :label="$t('rooms.settings.security.accessCode')">
            <b-input-group>
              <b-input-group-prepend>
                <!-- Generate random access code -->
                <b-button
                  v-on:click="genAccessCode"
                  variant="outline-secondary"
                ><i class="fas fa-dice"></i
                ></b-button>
              </b-input-group-prepend>
              <b-form-input
                id="settings-accessCode"
                :placeholder="$t('rooms.settings.security.unprotectedPlaceholder')"
                readonly
                :state="fieldState('accessCode')"
                type="number"
                v-model.number="settings.accessCode"
              ></b-form-input>
              <b-input-group-append>
                <!-- Clear access code -->
                <b-button
                  @click="clearAccessCode"
                  variant="outline-secondary"
                ><i class="fas fa-trash"></i
                ></b-button>
              </b-input-group-append>
            </b-input-group>
            <small class="text-muted">
              {{ $t('rooms.settings.security.accessCodeNote') }}
            </small>
          </b-form-group>

          <!-- Checkbox allow guests to access the room -->
          <b-form-group :state="fieldState('allowGuests')" :invalid-feedback="fieldError('allowGuests')">
            <b-form-checkbox :state="fieldState('allowGuests')" v-model="settings.allowGuests" switch>
              {{ $t('rooms.settings.security.allowGuests') }}
            </b-form-checkbox>
          </b-form-group>

          <!-- Checkbox allow users to become room members -->
          <b-form-group :state="fieldState('allowMembership')" :invalid-feedback="fieldError('allowMembership')">
            <b-form-checkbox :state="fieldState('allowMembership')" v-model="settings.allowMembership" switch>
              {{ $t('rooms.settings.security.allowNewMembers') }}
            </b-form-checkbox>
          </b-form-group>
        </div>

        <!-- Paticipants settings tab -->
        <div class="col-lg-3 col-sm-12">
          <h5>{{ $t('rooms.settings.participants.title') }}</h5>
            <!-- Max amount of participants -->
            <b-form-group :state="fieldState('maxParticipants')" :invalid-feedback="fieldError('maxParticipants')" :label="$t('rooms.settings.participants.maxParticipants')">
              <b-input-group>
                <b-form-input
                  min="1"
                  :placeholder="$t('rooms.settings.nonePlaceholder')"
                  type="number"
                  :state="fieldState('maxParticipants')"
                  v-model.number="settings.maxParticipants"
                ></b-form-input>
                <b-input-group-append>
                  <!-- Clear participants limit -->
                  <b-button
                    @click="clearMaxParticipants"
                    variant="outline-secondary"
                  ><i class="fas fa-trash"></i
                  ></b-button>
                </b-input-group-append>
              </b-input-group>
            </b-form-group>

            <!-- Radio default user role for logged in users only -->
            <b-form-group :state="fieldState('defaultRole')" :invalid-feedback="fieldError('defaultRole')" >
              <template v-slot:label>
                {{ $t('rooms.settings.participants.defaultRole.title') }}<br><small>{{ $t('rooms.settings.participants.defaultRole.onlyLoggedIn') }}</small>
              </template>
              <b-form-radio
                name="setting-defaultRole"
                v-model.number="settings.defaultRole"
                :state="fieldState('defaultRole')"
                value="1">
                {{ $t('rooms.settings.participants.defaultRole.participant') }}
              </b-form-radio>
              <b-form-radio
                name="setting-defaultRole"
                v-model.number="settings.defaultRole"
                :state="fieldState('defaultRole')"
                value="2">
                {{ $t('rooms.settings.participants.defaultRole.moderator') }}
              </b-form-radio>
            </b-form-group>

          <!-- Radio usage of the waiting room/guest lobby -->
          <b-form-group :state="fieldState('lobby')" :invalid-feedback="fieldError('lobby')" :label="$t('rooms.settings.participants.waitingRoom.title')">
            <b-form-radio
              name="setting-lobby"
              v-model.number="settings.lobby"
              :state="fieldState('lobby')"
              value="0">
              {{ $t('rooms.settings.participants.waitingRoom.disabled') }}
            </b-form-radio>
            <b-form-radio
              name="setting-lobby"
              v-model.number="settings.lobby"
              :state="fieldState('lobby')"
              value="1">
              {{ $t('rooms.settings.participants.waitingRoom.enabled') }}
            </b-form-radio>
            <b-form-radio
              name="setting-lobby"
              v-model.number="settings.lobby"
              :state="fieldState('lobby')"
              value="2">
              {{ $t('rooms.settings.participants.waitingRoom.onlyForGuestsEnabled') }}
            </b-form-radio>
          </b-form-group>
        </div>

        <!-- Permissions & Restrictions tab -->
        <div class="col-lg-3 col-sm-12">
          <h5>{{ $t('rooms.settings.permissions.title') }}</h5>
          <!-- Everyone can start a new meeting, not only the moderator -->
          <b-form-checkbox :state="fieldState('everyoneCanStart')" v-model="settings.everyoneCanStart" switch>
            {{ $t('rooms.settings.permissions.everyoneStart') }}
          </b-form-checkbox>
          <b-form-invalid-feedback :state="fieldState('everyoneCanStart')">{{fieldError('everyoneCanStart')}}</b-form-invalid-feedback>
          <!-- Mute everyones microphone on meeting join -->
          <b-form-checkbox :state="fieldState('muteOnStart')" v-model="settings.muteOnStart" switch>
            {{ $t('rooms.settings.permissions.muteMic') }}
          </b-form-checkbox>
          <b-form-invalid-feedback :state="fieldState('muteOnStart')">{{fieldError('muteOnStart')}}</b-form-invalid-feedback>
          <hr>
          <h5>{{ $t('rooms.settings.restrictions.title') }}</h5>
          <!-- Enable the restrictions, otherwise just send the settings, can be activated during the meeting -->
          <b-form-checkbox :state="fieldState('lockSettingsLockOnJoin')" v-model="settings.lockSettingsLockOnJoin" switch>
            {{ $t('rooms.settings.restrictions.enabled') }}
          </b-form-checkbox>
          <b-form-invalid-feedback :state="fieldState('lockSettingsLockOnJoin')">{{fieldError('lockSettingsLockOnJoin')}}</b-form-invalid-feedback>
          <!-- Disable the ability to use the webcam for non moderator-uses, can be changed during the meeting -->
          <b-form-checkbox :state="fieldState('lockSettingsDisableCam')" v-model="settings.lockSettingsDisableCam" switch>
            {{ $t('rooms.settings.restrictions.disableCam') }}
          </b-form-checkbox>
          <b-form-invalid-feedback :state="fieldState('lockSettingsDisableCam')">{{fieldError('lockSettingsDisableCam')}}</b-form-invalid-feedback>
          <!--
          Disable the ability to see the webcam of non moderator-uses,
          moderators can see all webcams,
          can be changed during the meeting
          -->
          <b-form-checkbox :state="fieldState('webcamsOnlyForModerator')" v-model="settings.webcamsOnlyForModerator" switch>
            {{ $t('rooms.settings.restrictions.onlyModSeeCam') }}
          </b-form-checkbox>
          <b-form-invalid-feedback :state="fieldState('webcamsOnlyForModerator')">{{fieldError('webcamsOnlyForModerator')}}</b-form-invalid-feedback>
          <!-- Disable the ability to use the microphone for non moderator-uses, can be changed during the meeting -->
          <b-form-checkbox :state="fieldState('lockSettingsDisableMic')" v-model="settings.lockSettingsDisableMic" switch>
            {{ $t('rooms.settings.restrictions.disableMic') }}
          </b-form-checkbox>
          <b-form-invalid-feedback :state="fieldState('lockSettingsDisableMic')">{{fieldError('lockSettingsDisableMic')}}</b-form-invalid-feedback>
          <!-- Disable the ability to send messages via the public chat for non moderator-uses, can be changed during the meeting -->
          <b-form-checkbox :state="fieldState('lockSettingsDisablePublicChat')" v-model="settings.lockSettingsDisablePublicChat" switch>
            {{ $t('rooms.settings.restrictions.disablePublicChat') }}
          </b-form-checkbox>
          <b-form-invalid-feedback :state="fieldState('lockSettingsDisablePublicChat')">{{fieldError('lockSettingsDisablePublicChat')}}</b-form-invalid-feedback>
          <!--
          Disable the ability to send messages via the private chat for non moderator-uses,
          private chats with the moderators is still possible
          can be changed during the meeting
          -->
          <b-form-checkbox :state="fieldState('lockSettingsDisablePrivateChat')" v-model="settings.lockSettingsDisablePrivateChat" switch>
            {{ $t('rooms.settings.restrictions.disablePrivateChat') }}
          </b-form-checkbox>
          <b-form-invalid-feedback :state="fieldState('lockSettingsDisablePrivateChat')">{{fieldError('lockSettingsDisablePrivateChat')}}</b-form-invalid-feedback>
          <!-- Disable the ability to edit the notes for non moderator-uses, can be changed during the meeting -->
          <b-form-checkbox :state="fieldState('lockSettingsDisableNote')" v-model="settings.lockSettingsDisableNote" switch>
            {{ $t('rooms.settings.restrictions.disableNoteEdit') }}
          </b-form-checkbox>
          <b-form-invalid-feedback :state="fieldState('lockSettingsDisableNote')">{{fieldError('lockSettingsDisableNote')}}</b-form-invalid-feedback>
          <!-- Disable the ability to see a list of all participants for non moderator-uses, can be changed during the meeting -->
          <b-form-checkbox :state="fieldState('lockSettingsHideUserList')" v-model="settings.lockSettingsHideUserList" switch>
            {{ $t('rooms.settings.restrictions.hideParticipantsList') }}
          </b-form-checkbox>
          <b-form-invalid-feedback :state="fieldState('lockSettingsHideUserList')">{{fieldError('lockSettingsHideUserList')}}</b-form-invalid-feedback>
        </div>
      </div>
      </b-overlay>
    </b-form>
  </div>
</template>

<script>
import Base from '../../api/base';
import env from './../../env.js';

export default {
  props: {
    room: Object
  },

  data () {
    return {
      settings: Object, // Room settings
      saving: false, // Settings are currently saved, display spinner
      welcomeMessageLimit: env.WELCOME_MESSAGE_LIMIT,
      errors: {}
    };
  },
  methods: {
    /**
     * Generate a new room access code with 9 digits
     */
    genAccessCode: function () {
      this.settings.accessCode =
          Math.floor(Math.random() * (999999999 - 111111112)) + 111111111;
      this.save();
    },
    /**
     * Save room settings
     */
    save () {
      // Set saving indicator
      this.saving = true;
      // Send new settings to the server
      Base.call('rooms/' + this.room.id, {
        method: 'put',
        data: this.settings
      }).then(response => {
        // Settings successfully saved
        // update the settings to the response from the server, feedback the changed were applied correctly
        this.settings = response.data.data;
        // inform parent component about changed settings
        this.$emit('settingsChanged');
        this.errors = {};
      }).catch((error) => {
        // Settings couldn't be saved
        if (error.response.status === 422) {
          this.errors = error.response.data.errors;
          return;
        }
        throw error;
      }).finally(() => {
        // Disable saving indicator
        this.saving = false;
      });
    },
    /**
     * Clear access code and save settings
     */
    clearAccessCode () {
      this.settings.accessCode = null;
      this.save();
    },
    /**
     * Clear meeting duration and save settings
     */
    clearDuration () {
      this.settings.duration = null;
      this.save();
    },
    /**
     * Clear max participants code and save settings
     */
    clearMaxParticipants () {
      this.settings.maxParticipants = null;
      this.save();
    },
    fieldState (field) {
      return this.errors[field] === undefined ? null : false;
    },
    fieldError (field) {
      if (this.fieldState(field) !== false) { return ''; }
      return this.errors[field].join('<br>');
    }
  },
  computed: {
    /**
     * Calculate the room type selection options
     * @returns {null|*}
     */
    roomTypeSelect () {
      if (this.settings.roomTypes) {
        return this.settings.roomTypes.map(roomtype => {
          var entry = {};
          entry.value = roomtype.id;
          entry.text = roomtype.description;
          return entry;
        });
      }
      return null;
    },
    /**
     * Count the chars of the welcome message
     * @returns {string} amount of chars in comparision to the limit
     */
    charactersLeftWelcomeMessage () {
      var char = this.settings.welcome
        ? this.settings.welcome.length
        : 0;
      return char + ' / ' + this.welcomeMessageLimit;
    }
  },
  created () {
    // Load all room settings
    Base.call('rooms/' + this.room.id + '/settings')
      .then(response => {
        // fetch successful
        this.settings = response.data.data;
      });
  }
};
</script>
<style scoped></style>
