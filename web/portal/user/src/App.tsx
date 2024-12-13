import { StoreContainer } from '@irontec/ivoz-ui';
import { CssBaseline, LinearProgress } from '@mui/material';
import { LocalizationProvider } from '@mui/x-date-pickers';
import { AdapterDateFns } from '@mui/x-date-pickers/AdapterDateFns';
import { useEffect } from 'react';
import { useTranslation } from 'react-i18next';
import { BrowserRouter } from 'react-router-dom';
import store, { useStoreActions, useStoreState } from 'store';

import { StyledAppApiLoading } from './App.styles';
import AppRoutesGuard from './router/AppRoutesGuard';
import { languagesList } from './translations/languages';

export default function App(): JSX.Element {
  StoreContainer.store = store;
  const setLanguages = useStoreActions((actions) => actions.i18n.setLanguages);
  const setLoginProps = useStoreActions(
    (actions) => actions.auth.setLoginProps
  );
  const apiSpecStore = useStoreActions((actions) => {
    return actions.spec;
  });
  const authStore = useStoreActions((actions) => actions.auth);
  const token = useStoreState((actions) => actions.auth.token);
  const aboutMeResetProfile = useStoreActions(
    (actions) => actions.userStatus.status.resetProfile
  );
  const aboutMeInit = useStoreActions(
    (actions) => actions.userStatus.status.init
  );
  const aboutMe = useStoreState((state) => state.userStatus.status.profile);
  const loadProfile = useStoreActions(
    (actions) => actions.userStatus.status.load
  );
  const loggedIn = useStoreState((state) => state.auth.loggedIn);

  useTranslation();

  useEffect(() => {
    if (loggedIn && token && !aboutMe) {
      loadProfile();
    }
  }, [loggedIn, token, aboutMe, loadProfile]);

  useEffect(() => {
    setLanguages(languagesList);
    setLoginProps({
      path: '/user_login',
    });

    apiSpecStore.setSessionStoragePrefix('IP-user-');
    apiSpecStore.init();
    authStore.setSessionStoragePrefix('IP-user-');
    authStore.init();

    aboutMeResetProfile();
    aboutMeInit();
  }, [
    setLanguages,
    apiSpecStore,
    authStore,
    token,
    aboutMeInit,
    aboutMeResetProfile,
  ]);

  const apiSpec = useStoreState((state) => state.spec.spec);

  if (!apiSpec || Object.keys(apiSpec).length === 0) {
    return (
      <StyledAppApiLoading>
        <LinearProgress />
        <br />
        Loading API definition...
      </StyledAppApiLoading>
    );
  }

  return (
    <LocalizationProvider dateAdapter={AdapterDateFns}>
      <CssBaseline />
      <div>
        <BrowserRouter>
          <AppRoutesGuard apiSpec={apiSpec} />
        </BrowserRouter>
      </div>
    </LocalizationProvider>
  );
}
