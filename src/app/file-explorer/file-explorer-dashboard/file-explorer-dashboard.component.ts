import { Component, Input, Output, EventEmitter, OnInit, ViewChild, AfterContentInit } from '@angular/core';
import { FileElement} from "../../models/file-explorer";
import { MatMenu, MatMenuTrigger } from '@angular/material/menu';
import { MediaChange, MediaObserver } from '@angular/flex-layout';
import { MatDialog } from '@angular/material/dialog';
import { NewfolderdiaologComponent } from '../newfolderdiaolog/newfolderdiaolog.component';
import { RenamefolderdiaologComponent } from '../renamefolderdiaolog/renamefolderdiaolog.component';
import { AuthenticationService } from '../../services/authentication.service';
import { Router } from '@angular/router';
import { MatGridList } from '@angular/material';

@Component({
  selector: 'app-file-explorer-dashboard',
  templateUrl: './file-explorer-dashboard.component.html',
  styleUrls: ['./file-explorer-dashboard.component.scss']
})
export class FileExplorerDashboardComponent implements OnInit, AfterContentInit{

  constructor(public dialog: MatDialog,public authService: AuthenticationService,public router: Router,private observableMedia: MediaObserver) {}


  @ViewChild('grid', {static: false}) grid: MatGridList;
  gridByBreakpoint = {
    xl: 12,
    lg: 10,
    md: 4,
    sm: 2,
    xs: 5
  }
  ngAfterContentInit() {
    this.observableMedia.asObservable().subscribe((change: MediaChange[]) => {
      this.grid.cols= this.gridByBreakpoint[change[0].mqAlias];
      //console.log(this.gridByBreakpoint[change[0].mqAlias]);
      console.log(this.fileElements,"fileele");
    });
  }
  @Input() fileElements: FileElement[];
  @Input() canNavigateUp: string;
  @Input() path: string;

  @Output() folderAdded = new EventEmitter<{ name: string }>();
  @Output() elementRemoved = new EventEmitter<FileElement>();
  @Output() elementRenamed = new EventEmitter<FileElement>();
  @Output() elementMoved = new EventEmitter<{ element: FileElement; moveTo: FileElement }>();
  @Output() navigatedDown = new EventEmitter<FileElement>();
  @Output() navigatedUp = new EventEmitter();

  ngOnInit(){
    console.log(this.fileElements,"fileElements");
  }

  deleteElement(element: FileElement) {
    this.elementRemoved.emit(element);
  }

  navigate(element: FileElement) {
    if (element.isfolder) {
      this.navigatedDown.emit(element);
    }
  }

  navigateUp() {
    this.navigatedUp.emit();
  }

  moveElement(element: FileElement, moveTo: FileElement) {
    this.elementMoved.emit({ element: element, moveTo: moveTo });
  }

  openNewFolderDialog() {
    let dialogRef = this.dialog.open(NewfolderdiaologComponent);
    dialogRef.afterClosed().subscribe(res => {
      if (res) {
        this.folderAdded.emit({ name: res });
      }
    });
  }

  openRenameDialog(element: FileElement) {
    let dialogRef = this.dialog.open(RenamefolderdiaologComponent);
    dialogRef.afterClosed().subscribe(res => {
      if (res) {
        element.name = res;
        this.elementRenamed.emit(element);
      }
    });
  }

  openMenu(event: MouseEvent, viewChild: MatMenuTrigger) {
    event.preventDefault();
    viewChild.openMenu();
  }

}
