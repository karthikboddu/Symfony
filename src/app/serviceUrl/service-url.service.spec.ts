import { TestBed } from '@angular/core/testing';

import { ServiceUrlService } from './service-url.service';

describe('ServiceUrlService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: ServiceUrlService = TestBed.get(ServiceUrlService);
    expect(service).toBeTruthy();
  });
});
