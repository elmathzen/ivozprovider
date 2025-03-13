import { Login as DefaultLogin } from '@irontec/ivoz-ui/components';
import { EntityValidator } from '@irontec/ivoz-ui/entities/EntityInterface';
import { useEffect, useState } from 'react';
import { useLocation, useNavigate } from 'react-router-dom';
import { useStoreActions, useStoreState } from 'store';
import TwoFactorVerify from './TwoFactorVerify';

interface LoginProps {
  validator?: EntityValidator;
  email?: string;
  token?: string;
}

export default function Login(props: LoginProps): JSX.Element | null {
  const { validator, email, token } = props;
  const location = useLocation();
  const navigate = useNavigate();
  const loggedIn = useStoreState((state) => state.auth.loggedIn);
  const exchangeToken = useStoreActions(
    (actions) => actions.auth.exchangeToken
  );
  const [twoFactorRequired, setTwoFactorRequired] = useState(false);
  const [tempToken, setTempToken] = useState('');

  useEffect(() => {
    if (email && token) {
      exchangeToken({
        username: email,
        token: token ?? '',
      })
        .then((success: boolean) => {
          if (!success) {
            console.error('Unable to echange token');

            return;
          }

          navigate(`${location.pathname}`, {
            replace: true,
            preventScrollReset: true,
          });
        })
        .catch((err: string) => {
          console.error(err);
        });

      return;
    }
  }, [email, token, exchangeToken, navigate, location.pathname]);

  if (loggedIn || (email && token)) {
    return null;
  }

  // If 2FA verification is required, show the verification component
  if (twoFactorRequired && tempToken) {
    return (
      <TwoFactorVerify
        tempToken={tempToken}
        onCancel={() => {
          setTwoFactorRequired(false);
          setTempToken('');
        }}
      />
    );
  }

  const marshaller = (values: { username: string; password: string }) => {
    return {
      email: values.username,
      password: values.password,
    };
  };

  // Handle login response to check for 2FA requirement
  const onLoginResponse = (response: any) => {
    if (response && response.twoFactorRequired && response.tempToken) {
      setTwoFactorRequired(true);
      setTempToken(response.tempToken);
      return false; // Prevent default login success handling
    }
    return true; // Continue with default login success handling
  };

  return (
    <DefaultLogin
      validator={validator}
      marshaller={marshaller}
      onLoginResponse={onLoginResponse}
    />
  );
}
