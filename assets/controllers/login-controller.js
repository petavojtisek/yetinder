// A Stimulus JavaScript controller file
// https://stimulus.hotwired.dev
// @see templates/security/login.html.twig
// More info on Symfony UX https://ux.symfony.com

import { Controller } from '@hotwired/stimulus';

/*
 * The following line makes this controller "lazy": it won't be downloaded until needed
 * See https://github.com/symfony/stimulus-bridge#lazy-controllers
 */
/* stimulusFetch: 'lazy' */
export default class extends Controller {
  static targets = ['username', 'password']

  // /!\ in a real application, the user/password should never be hardcoded /!\
  // but for the demo application, it's very convenient to do so

  prefillJohnUser() {
    this.usernameTarget.value = 'john_user'
    this.passwordTarget.value = 'kitten'
  }

  prefillJaneAdmin() {
    this.usernameTarget.value = 'jane_admin'
    this.passwordTarget.value = 'kitten'
  }

  prefillPetr() {
    this.usernameTarget.value = 'petr'
    this.passwordTarget.value = 'petrpetr'
  }



  prefillKatinaMccall() {
    this.usernameTarget.value = 'Katina'
    this.passwordTarget.value = 'MccallMccall'
  }

  prefillPhillipBeltran() {
    this.usernameTarget.value = 'Phillip'
    this.passwordTarget.value = 'BeltranBeltran'
  }

  prefillMillieStephenson() {
    this.usernameTarget.value = 'Millie'
    this.passwordTarget.value = 'StephensonStephenson'
  }

  prefillLennyKerr() {
    this.usernameTarget.value = 'Lenny'
    this.passwordTarget.value = 'KerrKerrKerr'
  }


  prefillEdisonLyons() {
    this.usernameTarget.value = 'Edison'
    this.passwordTarget.value = 'LyonsLyons'
  }

  prefillCathrynBenitez() {
    this.usernameTarget.value = 'Cathryn'
    this.passwordTarget.value = 'BenitezBenitez'
  }

  prefillLadonnaMorrison() {
    this.usernameTarget.value = 'Ladonna'
    this.passwordTarget.value = 'MorrisonMorrison'
  }

  prefillJulianneMerritt() {
    this.usernameTarget.value = 'Julianne'
    this.passwordTarget.value = 'MerrittMerritt'
  }

  prefillOswaldoLowe() {
    this.usernameTarget.value = 'Oswaldo'
    this.passwordTarget.value = 'LoweLowe'
  }

  prefillJosefRandall() {
    this.usernameTarget.value = 'Josef'
    this.passwordTarget.value = 'RandallRandall'
  }

  togglePasswordInputType() {
    if ('password' === this.passwordTarget.type) {
      this.passwordTarget.type = 'text'
    } else {
      this.passwordTarget.type = 'password'
    }
  }
}
