import { Component, OnInit } from '@angular/core';
import { AuthenticationService } from './services/authentication.service';
import { first } from 'rxjs/operators';
import { Router, ActivatedRoute } from '@angular/router';
import { PostService } from './services/post.service';
import { FormControl } from '@angular/forms';
import { ThemeService } from './services/theme.service';
import { FileService } from './services/file.service';
import { FileElement } from './models/file-explorer';
import { Observable, BehaviorSubject } from 'rxjs';
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
  title = 'demoproject';
  darkTheme = new FormControl(false);
  public fileElements: Observable<FileElement[]>;
  constructor(public authService: AuthenticationService, private route: ActivatedRoute, private postService: PostService
    , public router: Router, private themeService: ThemeService,public fileService: FileService
  ) {

    console.log(this.router.url,"router");
  }
  isAuthenticated: boolean;
  isTokenValid: any;
  allPost: any;
  admin: boolean;
  loggedin: boolean;

  currentRoot: FileElement;
  currentPath: string;
  canNavigateUp = false;
  ngOnInit() {

    console.log("isauth", this.isAuthenticated);
    //  if(this.isAuthenticated){
    //   this.router.navigate(['/home']);
    //  }else{
    //   this.router.navigate(['/login']);
    //  }

    this.postService.getPostsByHomeScreen()
      .pipe(first())
      .subscribe(
        data => {
          this.allPost = data
          //this.allImg = data[0]['postfile'];
          console.log("data", this.allPost);
          //console.log("imgdata",data['postfile']);
        },
        error => {
          console.log("errors", error);
        });
        
        const folderA = this.fileService.add({ name: 'Folder A', isFolder: true, parent: 'root' });
        this.fileService.add({ name: 'Folder B', isFolder: true, parent: 'root' });
        this.fileService.add({ name: 'Folder C', isFolder: true, parent: folderA.id });
        this.fileService.add({ name: 'File A', isFolder: false, parent: 'root' });
        this.fileService.add({ name: 'File B', isFolder: false, parent: 'root' });
    
        this.updateFileElementQuery();

  }


  addFolder(folder: { name: string }) {
    this.fileService.add({ isFolder: true, name: folder.name, parent: this.currentRoot ? this.currentRoot.id : 'root' });
    this.updateFileElementQuery();
  }

  removeElement(element: FileElement) {
    this.fileService.delete(element.id);
    this.updateFileElementQuery();
  }

  navigateToFolder(element: FileElement) {
    this.currentRoot = element;
    this.updateFileElementQuery();
    this.currentPath = this.pushToPath(this.currentPath, element.name);
    this.canNavigateUp = true;
  }

  navigateUp() {
    if (this.currentRoot && this.currentRoot.parent === 'root') {
      this.currentRoot = null;
      this.canNavigateUp = false;
      this.updateFileElementQuery();
    } else {
      this.currentRoot = this.fileService.get(this.currentRoot.parent);
      this.updateFileElementQuery();
    }
    this.currentPath = this.popFromPath(this.currentPath);
  }

  moveElement(event: { element: FileElement; moveTo: FileElement }) {
    this.fileService.update(event.element.id, { parent: event.moveTo.id });
    this.updateFileElementQuery();
  }

  renameElement(element: FileElement) {
    this.fileService.update(element.id, { name: element.name });
    this.updateFileElementQuery();
  }

  updateFileElementQuery() {
    this.fileElements = this.fileService.queryInFolder(this.currentRoot ? this.currentRoot.id : 'root');
    console.log(this.fileElements,"Sdsd");
  }

  pushToPath(path: string, folderName: string) {
    let p = path ? path : '';
    p += `${folderName}/`;
    return p;
  }

  popFromPath(path: string) {
    let p = path ? path : '';
    let split = p.split('/');
    split.splice(split.length - 2, 1);
    p = split.join('/');
    return p;
  }

  async ngOnDestroy() {
 

    await this.authService.logout();
  }

}
