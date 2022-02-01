import React, { useState } from 'react';
import { Tooltip, Fab } from '@mui/material';
import QueueIcon from '@mui/icons-material/Queue';
import SearchIcon from '@mui/icons-material/Search';
import { ContentFilter } from 'lib/components/List/Filter/ContentFilter';
import EntityService from 'lib/services/entity/EntityService';
import _ from 'lib/services/translations/translate';
import { StyledActionButtonContainer, StyledLink, StyledFab } from './ListContent.styles';
import { Box } from '@mui/system';
import ContentTable from './Table/ContentTable';
import ContentCard from './Card/ContentCard';

interface ContentTableProps {
  path: string,
  entityService: EntityService,
  rows: any,
  preloadData: boolean
}

export default function ListContent(props: ContentTableProps): JSX.Element {
  const {
    path,
    entityService,
    rows,
    preloadData
  } = props;

  const acl = entityService.getAcls();
  const [showFilters, setShowFilters] = useState(false);
  const handleFiltersClose = () => {
    setShowFilters(false);
  };

  const filterButtonHandler = (/*event: MouseEvent<HTMLButtonElement>*/) => {
    setShowFilters(!showFilters);
  };

  return (
    <React.Fragment>
      <StyledActionButtonContainer>
        <div />
        <div>
          <Tooltip title={_('Search')} arrow>
            <StyledFab onClick={filterButtonHandler}>
              <SearchIcon />
            </StyledFab>
          </Tooltip>
          {acl.create && <StyledLink to={`${path}/create`}>
            <Tooltip title="Add" arrow>
              <Fab color="secondary" size="small" variant="extended">
                <QueueIcon />
              </Fab>
            </Tooltip>
          </StyledLink>}
        </div>
      </StyledActionButtonContainer>

      <ContentFilter
        entityService={entityService}
        open={showFilters}
        handleClose={handleFiltersClose}
        path={path}
        preloadData={preloadData}
      />

      <Box sx={{ display: { xs: 'none', md: 'block' } }}>
        <ContentTable
          entityService={entityService}
          rows={rows}
          path={path}
        />
      </Box>
      <Box sx={{ display: { xs: 'block', md: 'none' } }}>
        <ContentCard
          entityService={entityService}
          rows={rows}
          path={path}
        />
      </Box>
    </React.Fragment >
  );
}