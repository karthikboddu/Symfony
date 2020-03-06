import { Component, OnInit , Input, Output, EventEmitter} from '@angular/core';
import { MatDialog } from '@angular/material';
import { UploadService } from '../services/upload.service';
import { UploadDialogComponent } from './upload-dialog/upload-dialog.component';
import { FileElement } from '../models/file-explorer';
import { FileService } from '../services/file.service';
import { first } from 'rxjs/operators';
import { Observable } from 'rxjs';
import { Response } from '../models/post';
import {FileResponse} from '../models/file-explorer';
@Component({
  selector: 'app-upload',
  templateUrl: './upload.component.html',
  styleUrls: ['./upload.component.scss']
})
export class UploadComponent implements OnInit {

  constructor(public dialog: MatDialog, public uploadService: UploadService,public fileService:FileService) { }

  currentRoot: FileElement;
  userfiledata : any;
  fe :FileElement[];
  public fileElements: Observable<FileElement[]>;
  fileReponse : FileResponse;
  ngOnInit() {
   
  }

  // async ngOnDestroy() {
  //   if (this.userfiledata) {
  //       this.userfiledata.unsubscribe();
  //   }

    
  // }
  newfileElement: FileElement;
  fileUploadId ;
  addFiles(folder) {
    debugger
    if(this.fileService.getFileEle()){
      this.currentRoot = this.fileService.getFileEle();
    }
   
   for (let i = 0; i < folder.name.length; i++) {
     console.log(folder.name[i].name,"fname");
    this.newfileElement = this.fileService.add({ isfolder: false, name: folder.name[i].name, parent: this.currentRoot ? this.currentRoot.fid : 'root' ,id:''});
  }
   this.fileService.addFilesAndFolders(this.newfileElement.fid,folder.name,'false',this.currentRoot ? this.currentRoot.fid : 'root')
   .pipe(first())
   .subscribe(data=>{
       console.log("addData",data);

     },
     error =>{
       console.log("errors", error);
     });


    this.updateFileElementQuery();
 }


 updateFileElementQuery() {
   debugger
  this.fileElements = this.fileService.queryInFolder(this.currentRoot ? this.currentRoot.fid : 'root');
  console.log(this.fileElements,"Sdsd");
}

}
