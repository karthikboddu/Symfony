import { Component, OnInit } from '@angular/core';
import { AuthenticationService } from 'src/app/services/authentication.service';
import { ActivatedRoute, Router } from '@angular/router';
import { PostService } from 'src/app/services/post.service';
import { ThemeService } from 'src/app/services/theme.service';

@Component({
  selector: 'app-logo',
  templateUrl: './logo.component.html',
  styleUrls: ['./logo.component.scss']
})
export class LogoComponent implements OnInit {

  constructor(public authService : AuthenticationService,private route: ActivatedRoute,private postService: PostService
    , private router: Router,private themeService:ThemeService) { }
    isAuthenticated: boolean = false;
  ngOnInit() {
    this.isAuthenticated = this.authService.isLoggedIn;
  }
  logoClicked() {
    this.router.navigate(["home"]);
  }
}
