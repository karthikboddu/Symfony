import { Component, Input, Output, EventEmitter, OnInit } from '@angular/core';
import { FileElement} from "../models/file-explorer";
import { MatMenu, MatMenuTrigger } from '@angular/material/menu';

import { MatDialog } from '@angular/material/dialog';
import { NewfolderdiaologComponent } from './newfolderdiaolog/newfolderdiaolog.component';
import { RenamefolderdiaologComponent } from './renamefolderdiaolog/renamefolderdiaolog.component';
import { AuthenticationService } from '../services/authentication.service';
import { Router } from '@angular/router';
import { UploadService } from '../services/upload.service';
import { FileService } from '../services/file.service';
import { first } from 'rxjs/operators';
import { Observable } from 'rxjs';
@Component({
  selector: 'file-explorer',
  templateUrl: './file-explorer.component.html',
  styleUrls: ['./file-explorer.component.scss']
})
export class FileExplorerComponent implements OnInit{

  constructor(public dialog: MatDialog,public authService: AuthenticationService,public router: Router,public fileService: FileService,public uploadService:UploadService) {}
  currentRoot: FileElement;
  fEle : FileElement[];
  currentPath: string;
  canNavigateUp = false;
  newid:any;
  public fileElements: Observable<FileElement[]>;

  ngOnInit() {
    debugger
    console.log("fileexpolorer");
    this.fileService.getFilesAndFolders()
    .pipe(first())
    .subscribe(data=>{
      debugger
        this.fEle = data;
        console.log("filedata",this.fEle);
        for (let i = 0; i < this.fEle.length; i++) {
          const folderA =   this.fileService.addSubscribe(this.fEle[i]);
        }
        this.fEle.forEach(element => {
          this.newid = 0;
          
          this.newid++;
        });

        //this.fileService.add(this.fEle['2']);
        this.updateFileElementQuery();
        console.log("filedata",data);
      },
      error =>{
        console.log("errors", error);
      });
      this.updateFileElementQuery();
      console.log(this.uploadService.queryInFolder(),"querinfolder");


  }


  newfileElement: FileElement;
  fuId ;
  addFolder(folder: { name: string }) {
    console.log(this.uploadService.queryInFolder(),"querinfolder");
    console.log("SD",this.currentRoot);
    this.newfileElement = this.fileService.add({ isfolder: true, name: folder.name, parent: this.currentRoot ? this.currentRoot.fid : 'root',id:'' });
    this.fileService.addFilesAndFolders(this.newfileElement.fid,folder.name,'true',this.currentRoot ? this.currentRoot.fid : 'root')
    .pipe(first())
    .subscribe(data=>{
        console.log("addData",data);
      },
      error =>{
        console.log("errors", error);
      });



    this.updateFileElementQuery();
  }

   addFiles(folder: string) {
     debugger
    console.log("hhSD",folder);
    //this.newfileElement = this.fileService.add({ isfolder: true, name: folder.name, parent: this.currentRoot ? this.currentRoot.fid : 'root' });
    // this.fileService.addFilesAndFolders(this.newfileElement.fid,folder.name,'true',this.currentRoot ? this.currentRoot.fid : 'root')
    // .pipe(first())
    // .subscribe(data=>{
    //     console.log("addData",data);
    //   },
    //   error =>{
    //     console.log("errors", error);
    //   });



    // this.updateFileElementQuery();
  }

  removeElement(element: FileElement) {
    this.fileService.delete(element.fid);
    this.updateFileElementQuery();
  }

  navigateToFolder(element: FileElement) {
    debugger
    this.currentRoot = element;
    this.updateFileElementQuery();
    this.fileService.setFileEle(element);
    this.fileService.getFilesAndFoldersById(element.id).subscribe((res:any)=>{
      console.log(res,"folderbyid");
    });
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
    this.fileService.update(event.element.fid, { parent: event.moveTo.fid });
    this.updateFileElementQuery();
  }

  renameElement(element: FileElement) {
    this.fileService.update(element.fid, { name: element.name });
    this.updateFileElementQuery();
  }

  updateFileElementQuery() {
    this.fileElements = this.fileService.queryInFolder(this.currentRoot ? this.currentRoot.fid : 'root');
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
