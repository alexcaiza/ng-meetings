import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DocentesNavComponent } from './docentes-nav.component';

describe('DocentesNavComponent', () => {
  let component: DocentesNavComponent;
  let fixture: ComponentFixture<DocentesNavComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DocentesNavComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DocentesNavComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
