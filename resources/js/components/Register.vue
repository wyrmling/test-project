<template>
  <v-app>
    <div
        v-if="!registered"
    >
      <h1 class="text-2xl font-bold mb-4">Register new user</h1>

      <v-alert
        :value="alert"
        color="red"
        dense
        prominent
        text
        type="error"
      >{{ alertMessage }}</v-alert>

      <v-form
          ref="form"
          v-model="valid"
          lazy-validation
      >
        <v-text-field
            class="rounded-pill"
            outlined
            background-color="white"
            v-model="fullName"
            :rules="nameRules"
            label="Full name"
            required
        ></v-text-field>

        <v-autocomplete
            class="rounded-pill"
            outlined
            background-color="white"
            v-model="countryId"
            :items="countriesList"
            :rules="[v => !!v || 'Country is required']"
            menu-props="auto"
            label="Country"
            required
            single-line
            item-text="name"
            item-value="idd"
        >
          <template #selection="{ item }">
            <span class="flag-emoji">{{ countryFlag }}</span>&nbsp;{{ item.name }}
          </template>
          <template v-slot:item="slotProps">
            <span class="flag-emoji">{{slotProps.item.flag}}</span>&nbsp;{{slotProps.item.name}}
          </template>
        </v-autocomplete>

        <v-text-field
            class="rounded-pill"
            outlined
            background-color="white"
            :disabled="!countryId"
            v-model="phoneNumber"
            label="Phone number"
            required
            :rules="phoneRules"
            @input="onPhoneNumberInput"
            :prefix="countryId"
        >
        </v-text-field>

        <v-text-field
            class="rounded-pill"
            outlined
            background-color="white"
            v-model="email"
            :rules="emailRules"
            label="E-mail"
            required
        ></v-text-field>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
              color="primary"
              text
              @click="submit"
          >
            Register
          </v-btn>
        </v-card-actions>

      </v-form>
    </div>

    <v-alert
      :value="registered"
      type="success"
      dark
      prominent
      border="top"
      transition="scale-transition"
      max-width="600"
      class="mx-auto"
    >
      <p>You have successfully completed the registration on Test project.</p>
      <p>Thank you for using our application!</p>
      <v-divider
        class="my-4"
      ></v-divider>
      Go to <a :href="loginRoute">Login</a> page.
    </v-alert>
  </v-app>
</template>

<script>
import countries from '@/json/countries.json';
import { polyfillCountryFlagEmojis } from 'country-flag-emoji-polyfill';
import { parsePhoneNumber } from 'awesome-phonenumber';

polyfillCountryFlagEmojis();

export default {
  props: { registerRoute: String, loginRoute: String },
  computed: {
    countriesList: () => {
      return countries.sort((a, b) => {
        if (a.name > b.name) {
          return 1;
        }
        if (a.name < b.name) {
          return -1;
        }
        return 0;
      });
    },
    countryFlag() {
      return this.countriesList.find(c => c.idd === this.countryId).flag;
    },
  },
  data() {
    return {
      alert: false,
      alertMessage: null,
      valid: true,
      registered: false,
      fullName: '',
      nameRules: [
        v => !!v || 'Name is required',
      ],
      email: '',
      emailRules: [
        v => !!v || 'E-mail is required',
        v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
      ],
      countryId: null,
      phoneNumber: '',
      phoneNumberInput: '',
      phoneRules: [
        v => !!v || 'Phone number is required',
        v => {
          const pn = parsePhoneNumber(this.countryId + v);
          return pn.valid || 'Phone is not valid';
        },
      ],
    }
  },
  watch: {
    countryId(n, o) {
      // this.phoneNumber = '';
      this.validate();
    },
    alert(n) {
      if (n) {
        setTimeout(() => {
          this.alert = false;
          this.alertMessage = null;
        }, 5000)
      }
    }
  },
  methods: {
    onPhoneNumberInput(val) {
      if (val !== '') {
        const pn = parsePhoneNumber(this.countryId + val);
        if (pn.valid) {
          const cleanedVal = val.replace(/[ -]/g, '');
          const formatRegex = /^(\d{0,6})(\d{3})(\d{2})(\d{2})$/;
          this.phoneNumber = cleanedVal.replace(formatRegex, '$1 $2-$3-$4');
          this.phoneNumberInput = pn.number.e164;
        }
      }
    },
    validate() {
      return this.$refs.form.validate()
    },
    reset() {
      this.$refs.form.reset()
    },
    resetValidation() {
      this.$refs.form.resetValidation()
    },
    async submit() {
      const isValid = this.validate();

      if (isValid) {
        const form = {
          fullName: this.fullName,
          countryId: this.countryId,
          countryName: this.countriesList.find(c => c.idd === this.countryId)?.name,
          phoneNumber: this.phoneNumberInput,
          email: this.email,
        };

        axios.post(this.registerRoute, form)
          .then(response => {
            if (response.status === 201) {
              this.registered = true;
            }
          })
          .catch(reason => {
            if (reason.response.data.errors) {
              this.alert = true;
              this.alertMessage = reason.response.data.message;
            }
          });
      }
    },
  },
};
</script>

<style lang="scss">
  .v-application .v-application--wrap {
    min-height: unset;
  }

  .flag-emoji {
    font-family: "Twemoji Country Flags", "Helvetica", "Comic Sans", serif;
  }
</style>
