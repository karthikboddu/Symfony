import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-header-navbar',
  templateUrl: './header-navbar.component.html',
  styleUrls: ['./header-navbar.component.scss']
})
export class HeaderNavbarComponent implements OnInit {

  constructor(private router:Router) { }

  ngOnInit() {
  }
  onTabClick(tab: any) {



 
        this.router.navigate([tab.link]);
      
    
  }
  public isActive(url: string) {
    //TODO: This is wrong use Page_names from appconstants
    return window.location.pathname.toLowerCase().startsWith(url.toLowerCase());
  }
}
