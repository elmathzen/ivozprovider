import ArrowForwardIcon from '@mui/icons-material/ArrowForward';
import RotateLeftIcon from '@mui/icons-material/RotateLeft';
import { CreateCSSProperties, styled } from '@mui/styles';

const sharedStyles: CreateCSSProperties = {
  color: 'green',
  verticalAlign: 'bottom',
};

export const StyledStatusIconArrowForwardIcon = styled(ArrowForwardIcon)(() => {
  return {
    ...sharedStyles,
  };
});

export const StyledStatusIconRotateLeftIcon = styled(RotateLeftIcon)(() => {
  return {
    ...sharedStyles,
  };
});
