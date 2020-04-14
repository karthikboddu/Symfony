import { Injectable } from '@angular/core';

export const darkTheme = {
  'primary-color': '#455363',
  'background-color': '#1f2935',
  'text-color': '#fff'
};

export const lightTheme = {
  'primary-color': '#fff',
  'background-color': '#e5e5e5',
  'text-color': '#2d2d2d'
};

export const viewPostTheme = {
  'primary-color': '#fff',
  'background-color': 'rgba(32, 103, 97, 0.38)',
  'text-color': '#2d2d2d'
};

@Injectable({ providedIn: 'root' })
export class ThemeService {
    toggleDark() {
    this.setTheme(darkTheme);
  }

  toggleLight() {
    this.setTheme(lightTheme);
  }

viewPostTheme(){
  this.setTheme(viewPostTheme);
}

  private setTheme(theme: {}) {
    console.log(theme);
    Object.keys(theme).forEach(k =>
      document.documentElement.style.setProperty(`--${k}`, theme[k])
    );
  }
}
