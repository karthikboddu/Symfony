import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { FileExplorerDashboardComponent } from './file-explorer-dashboard.component';

describe('FileExplorerDashboardComponent', () => {
  let component: FileExplorerDashboardComponent;
  let fixture: ComponentFixture<FileExplorerDashboardComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ FileExplorerDashboardComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(FileExplorerDashboardComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
