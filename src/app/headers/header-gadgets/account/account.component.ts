import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthenticationService } from 'src/app/services/authentication.service';

@Component({
  selector: 'app-account',
  templateUrl: './account.component.html',
  styleUrls: ['./account.component.scss']
})
export class AccountComponent implements OnInit {

  constructor(public authService : AuthenticationService, private router: Router) { }
  expanded: boolean = false;
  isLoggedIn: boolean;
  ngOnInit() {
    this.isLoggedIn = this.authService.isLoggedIn;
  }
  onLogIn() {
    debugger
    this.router.navigate([{ outlets: { modal: ['login'] } }]);
  }
  onLogout() {
    this.authService.logout();
    this.expanded = false;
    this.router.navigate(['/home']);
  }

  onManageProfile() {
    this.expanded = false;
    this.router.navigate(['my-dashboard', 'manage-profile']);
  }
}
