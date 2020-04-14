import { Component, OnInit, ViewChild, ViewContainerRef, ComponentFactoryResolver, Type, Inject, ElementRef } from '@angular/core';
import { HeadersComponent } from 'src/app/headers/headers.component';
import { ActivatedRoute } from '@angular/router';
import { FileExplorerComponent } from 'src/app/file-explorer/file-explorer.component';
import { HomeComponent } from 'src/app/home/home.component';
import { LoginComponent } from 'src/app/login/login.component';
import {ExploreComponent} from 'src/app/layout/explore/explore.component'
import { AdminComponent } from 'src/app/Admin/admin/admin.component';

@Component({
  selector: 'app-container',
  templateUrl: './container.component.html',
  styleUrls: ['./container.component.scss']
})
export class ContainerComponent implements OnInit {
  @ViewChild('pageLayout', { read: ViewContainerRef }) pageLayoutRef: ViewContainerRef;
  constructor(private componentFactoryResolver: ComponentFactoryResolver,private route: ActivatedRoute) { }
  component : any;
  ngOnInit() {
    
  }
  ngAfterViewInit() {
    let pageName = this.getPageName();
   this.component =  this.loadComponent(pageName);
    this.createComponent(this.component);
  }
  loadComponent(pageName){
    debugger
    if(pageName =='fileexplorer'){
       this.component = FileExplorerComponent;
    }else if(pageName == 'home'){
      this.component = ExploreComponent;
    }else if(pageName == 'login'){
      this.component = LoginComponent;
    }
    else if(pageName == 'admin'){
      this.component = AdminComponent;
    }
    console.log(this.component,"component");
    return this.component;
  }
  createComponent(component) {
    
    const factory = this.componentFactoryResolver.resolveComponentFactory(component);
    this.pageLayoutRef.clear();
    const componentRef = this.pageLayoutRef.createComponent(factory);
    // componentRef.instance.message = message;
  }

  getPageName(): string {
    let pageName = this.route.snapshot.data["pageName"];

    if (!pageName || pageName == '') {
      throw Error("No pageName provided to PageContainerComponent");
    }

    return pageName;
  }

}
